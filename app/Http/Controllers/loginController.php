<?php

namespace App\Http\Controllers;

use App\Mail\sendmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\Login;

class loginController extends Controller
{
    public function requestpin(Request $request)
    {
        $pin = rand(1000, 9999);
        $device = Login::where('email', '=', $request->email)->update(['pin' => $pin]);

        $data = array(
            'email' => $request->email
        );
        
        if ($device) {
            $maildetails = [
                'Subject' => 'Verify Your Login',
                'body' => 'Dear User,Your Required pin :' . $pin
            ];
            Mail::to($data['email'])->send(new sendmail($maildetails));
            return response()->json(
                [
                    'code' => 200,
                    'message' => "Success"
                ],
                200
            );

        } else {
            return response()->json(
                [
                    'code' => 404,
                    'message' => 'Check Your Email'
                ],
                404
            );
        }
    }
    public function verifypin(Request $request)
    {
        $pin = $request->pin;
        if ($pin != null) {
            $user = Login::where('email', '=', $request->email)->where('pin', '=', $pin)->first();
        } else {
            return response()->json(
                [
                    'code' => 404,
                    'message' => 'Pin Cannot be null'

                ],
                404
            );
        }
        $data = DB::table('register_users')->select("is_twostep_active", "secret_key")->where("email", "=", $request->email)->get();
        $data1 = json_decode($data);
        $is_twostep_active = $data[0]->is_twostep_active;
        $secret_key = $data[0]->secret_key;

        if ($user) {
            $verify = Login::select("is_twostep_active", "secret_key")->where('email', '=', $request->email)->update(['pin' => null]);
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
            return response()->json(
                [
                    'code' => 404,
                    'message' => 'Check Your Email & Pin'

                ],
                404
            );
        }
    }
    public function update(Request $request, $id)
    {
        $table = Login::find($id);
        $table->secret_key = $request->secret_key;
        $table->is_twostep_active = $request->is_twostep_active;
        $table->save();
        return response()->json(["code" => 200, 'message' => 'Successfully update'], 200);
    }
}