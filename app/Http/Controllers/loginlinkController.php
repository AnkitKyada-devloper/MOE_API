<?php
namespace App\Http\Controllers;

use App\Helpers\Helper;

use App\Models\Login;
use App\Mail\sendmail;
// use App\Models\loginlink;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use TheSeer\Tokenizer\Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class loginlinkController extends Controller
{
    public function requestlink(Request $request)
    {

        try {
            $validated = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email|exists:register_users',
                ]
            );
            if ($validated->fails()) {
                return Helper::validated($validated); 
            }

            $mail_link = Str::random(100);
            $user = Login::where('email', $request->email)->first();

            if ($user) {
                $user->update(['mail_link' => $mail_link]);
                $url = "https://kalptestfin.page.link/?link=https://interns.openeyes.com?PARAMETER=$mail_link&apn=com.oess.moe.moe&isi=12345533&ibi=com.oess.moe.moe&ifl=https://github.com/spideyonhigh";

                $maildetails = [
                    'Subject' => 'Verify Your Login',
                    'body' => 'Dear User,Please click he below link :' . $url
                ];
                Mail::to($request->email)->send(new sendmail($maildetails));
                return Helper::success('Send mail link');
            } else {
                return Helper::error('Mail is Incorrect');
            }
        } catch (Exception $e) {
            return Helper::catch();
        }

    }
    public function verifylink(Request $request)
    {
        try {
             $datas = Login::select('is_twostep_active', 'secret_key')->where('email', '=', $request->email)->get();
            foreach($datas as $data)
            {
                $is_twostep_active = $data['is_twostep_active'];
                $secret_key = $data['secret_key'];
            }

            $mail_link = $request->mail_link;
            if ($mail_link != null) {
                $userlink = Login::where('email', '=', $request->email)->where('mail_link', '=', $request->mail_link)->first();

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
                    return Helper::error('Mail is Incorrect');
                }
            } else {
                return Helper::error('Link can not be null');
            }
        }catch (Exception $e) {
            return Helper::catch();
        }

    }
}