<?php

namespace App\Http\Controllers;

use App\Mail\sendmail;
use Illuminate\Http\Request;
use Mail;
use Auth;
use App\Models\Login;

class loginController extends Controller
{
    public function requestpin(Request $request)
    {
        $pin = rand(1000,9999);
        $device = Login::where('email', '=', $request->email)->update(['pin' => $pin]);
        $data = array(
            'email' => $request->email
        );
        if ($device) {
               $maildetails =[
                    'Subject' => 'Verify Your Login',
                    'body' => 'Dear User,Your Required pin :' . $pin
            ];
            Mail::to($data['email'])->send(new sendmail($maildetails));
            return response()->json(["code" => 200, "message" => 'Required pin sent to your email']);
        } else {
            return response()->json(["code" => 404, "message" => 'Your email is not valid, Go to login']);
            
        }
    }
    public function verifypin(Request $request)
    {
        $user = Login::where('email', '=', $request->email)->where('pin', '=', $request->pin)->first();
       
        if ($user) {
            $verify = Login::where('email', '=', $request->email)->update(['pin' => null]);
            $tokenResult = $user->createToken('Access Token');
            return response()->json([
                    'message' => 'email&password  is correct ',
                    'code' => 200,
                    'access_token' => $tokenResult->accessToken
            ]);
            } else {
                return response()->json(['message' => 'Your email&pin is incorrect ','stauts' =>404],404);
            }
        }
    }

