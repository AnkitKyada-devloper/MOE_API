<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Mail\sendmail;
use App\Models\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use TheSeer\Tokenizer\Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Encryption\DecryptException;



class loginController extends Controller
{
    public function requestpin(Request $request)
    {
        try {
            $pin = rand(1000, 9999);
            $pin_expires_time = Carbon::now()->addSeconds(300);
            $device = Login::where('email', '=', $request->email)->update(['pin' => $pin, 'pin_expires_time' => $pin_expires_time]);
            $data = array(
                'email' => $request->email
            );

            if ($device) {
                $maildetails = [
                    'Subject' => 'Verify Your Login',
                    'body' => 'Dear User,Your Required pin :' . $pin
                ];

                Mail::to($data['email'])->send(new sendmail($maildetails));
                return Helper::success('Send Pin','');
            } else {
                return Helper::error('Mail is Incorrect');
            }
        } catch (Exception $e) {
            return Helper::catch();
        }
    }
    public function verifypin(Request $request)
    {
        try {
            $carbon = Carbon::now();
            $time = Login::where('email', '=', $request->email)->where('pin_expires_time', '>', $carbon)->first();
            if ($time) {
                $pin = $request->pin;
                if ($pin != null) {
                    $user = Login::where('email', '=', $request->email)->where('pin', '=', $pin)->first();
                } else {
                    return Helper::error('Pin can not be null');
                }

                $datas = Login::select('is_twostep_active', 'secret_key')->where('email', '=', $request->email)->get();

                foreach ($datas as $data) {
                    $is_twostep_active = $data['is_twostep_active'];
                    $secret_key = $data['secret_key'];
                }

                if ($user) {
                    $verify = Login::where('email', '=', $request->email)->update(['pin' => null]);
                    $tokenResult = $user->createToken('Access Token');
                    return response()->json([
                        'message' => 'email&password  is correct ',
                        'code' => 200,
                        'user' => Crypt::encryptString($user->id),
                        'is_twostep_active' => $is_twostep_active,
                        'secret_key' => $secret_key,
                        'access_token' => $tokenResult->accessToken
                        
                    ]);
                } else {
                    return Helper::error('Check your email & pin');
                }
            } else {
                return Helper::error('Pin Expired');
            }
        } catch (Exception $e) {
            return Helper::catch();
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $table = Login::find($id);
            $table->secret_key = $request->secret_key;
            $table->is_twostep_active = $request->is_twostep_active;
            $table->save();
            return Helper::success('Update data','');
        } catch (Exception $e) {
            return Helper::catch();
        }
    }
}