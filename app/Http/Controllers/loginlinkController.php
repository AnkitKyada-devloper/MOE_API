<?php
namespace App\Http\Controllers;

use App\Mail\sendmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\loginlink;
use App\Models\Login;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use TheSeer\Tokenizer\Exception;

class loginlinkController extends Controller
{
    public function requestlink(Request $request)
    {

        try {
            $validated = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email|exists:register_users,email',
                ]
            );

            if ($validated->fails()) {
                return response()->json(['code' => 422, 'message' => $validated->errors()], 422);
            }

            $mail_link = Str::random(100);
            $user = loginlink::where('email', $request->email)->first();

            if ($user) {
                $user->update(['mail_link' => $mail_link]);
                $url = "https://kalptestfin.page.link/?link=https://interns.openeyes.com?PARAMETER=$mail_link&apn=com.oess.moe.moe&isi=12345533&ibi=com.oess.moe.moe&ifl=https://github.com/spideyonhigh";

                $maildetails = [
                    'Subject' => 'Verify Your Login',
                    'body' => 'Dear User,Please click he below link :' . $url
                ];
                Mail::to($request->email)->send(new sendmail($maildetails));
                return response()->json(['code' => 200, 'message' => 'Successfully !..Send Mail'], 200);
            } else {
                return response()->json(['code' => 404, 'message' => 'Error'], 404);
            }
        } catch (Exception $e) {
            return response()->json(['code' => 500, 'message' => 'Error'], 500);
        }

    }
    public function verifylink(Request $request)
    {
        try {
             $datas = Login::select("is_twostep_active", "secret_key")->where("email", "=", $request->email)->get();
            foreach($datas as $data)
            {
                $is_twostep_active = $data['is_twostep_active'];
                $secret_key = $data['secret_key'];
            }
            $mail_link = $request->mail_link;
            if ($mail_link != null) {
                $userlink = loginlink::where('email', '=', $request->email)->where('mail_link', '=', $request->mail_link)->first();

                if ($userlink) {
                    $userlink->update(['mail_link' => null]);
                    $tokenResult = $userlink->createToken('Access Token');
                    return response()->json([
                        'code' => 200,
                        'message' => 'email is correct ',
                        'is_twostep_active' => $is_twostep_active,
                        'secret_key' => $secret_key,
                        'access_token' => $tokenResult->accessToken
                    ]);

                } else {
                    return response()->json(['code' => 404, 'message' => ' Your mail is invalid'], 404);
                }
            } else {
                return response()->json(['code' => 404, 'message' => 'Link Cannot be null'], 404);
            }
        }catch (Exception $e) {
            return response()->json(['code' => 500, 'message' => 'Error'], 500);
        }

    }
}