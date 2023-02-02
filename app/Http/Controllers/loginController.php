<?php

namespace App\Http\Controllers;

use App\Mail\sendmail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\Login;
use TheSeer\Tokenizer\Exception;


class loginController extends Controller
{
    public function requestpin(Request $request)
    {
        try {
            $pin = rand(1000, 9999);

            $otp_expires_time = Carbon::now()->addSeconds(300);
            $device = Login::where('email', '=', $request->email)->update(['pin' => $pin, 'otp_expires_time' => $otp_expires_time]);

            $data = array(
                'email' => $request->email
            );

            if ($device) {
                $maildetails = [
                    'Subject' => 'Verify Your Login',
                    'body' => 'Dear User,Your Required pin :' . $pin
                ];
                Mail::to($data['email'])->send(new sendmail($maildetails));
                return response()->json(['code' => 200, 'message' => "Success", 'otp_expires_time' => $otp_expires_time], 200);
            } else {
                return response()->json(['code' => 404, 'message' => 'Check Your Email'], 404);
            }
        } catch (Exception $e) {
            return response()->json(['code' => 500, 'message' => 'Error'], 500);
        }
    }
    public function verifypin(Request $request)
    {
        try {
            $date = Carbon::now();
            $time = Login::where('email', '=', $request->email)->where('otp_expires_time', '>', $date)->first();
            if ($time) {
                $pin = $request->pin;
                if ($pin != null) {
                    $user = Login::where('email', '=', $request->email)->where('pin', '=', $pin)->first();
                } else {
                    return response()->json(['code' => 404, 'message' => 'Pin Cannot be null'], 404);
                }

                $datas = Login::select("is_twostep_active", "secret_key")->where("email", "=", $request->email)->get();
                
                foreach($datas as $data)
            {
                $is_twostep_active = $data['is_twostep_active'];
                $secret_key = $data['secret_key'];
            }

                if ($user) {
                    $verify = Login::where('email', '=', $request->email)->update(['pin' => null]);
                    $tokenResult = $user->createToken('Access Token');
                    return response()->json([
                        'message' => 'email&password  is correct ',
                        'code' => 200,
                        'user' => $user->id,
                        'is_twostep_active' => $is_twostep_active,
                        'secret_key' => $secret_key,
                        'access_token' => $tokenResult->accessToken
                    ]);
                } else {
                    return response()->json(['code' => 404, 'message' => 'Check Your Email & Pin'], 404);
                }
            } else {
                return response()->json(['code' => 404, 'message' => 'Pin is Expired'], 404);
            }
        } catch (Exception $e) {
            return response()->json(['code' => 500, 'message' => 'Error'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $table = Login::find($id);
            $table->secret_key = $request->secret_key;
            $table->is_twostep_active = $request->is_twostep_active;
            $table->save();
            return response()->json(["code" => 200, 'message' => 'Successfully Update Data'], 200);
        } catch (Exception $e) {
            return response()->json(['code' => 500, 'message' => 'Error'], 500);
        }
    }
}