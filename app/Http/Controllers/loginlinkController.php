<?php namespace App\Http\Controllers;

use App\Mail\sendmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\loginlink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use TheSeer\Tokenizer\Exception;

class loginlinkController extends Controller {
    public function link(Request $request) {

        try {
            $validated=Validator::make($request->all(),
                    [ 'email'=> 'required|email|exists:register_users,email',
                    ]);

            if ($validated->fails()) {
                return response()->json(['code' => 422,'message' => $validated->errors()], 422);
            }

            $mail_link=Str::random(100);
            $user=loginlink::where('email', $request->email)->first();

            if ($user) {
                $user->update(['mail_link'=> $mail_link]);
                $url="https://interns.openeyes.com/token?". $mail_link;

                $maildetails=[ 'Subject'=>'Verify Your Login', 
                'body'=>'Dear User,Please click he below link :'. $url];
                Mail::to($request->email)->send(new sendmail($maildetails));
                return response()->json(['code' => 200,'message' => 'Successfully !..Send Mail'], 200);
            }
            else {
                return response()->json(['code' => 400,'message' => 'Error'], 400);
            }
        }
        catch (Exception $e) {
            return response()->json(['code'=> 500, 'message'=> 'Error'], 500);
        }

    }

    public function verifylink(Request $request) {
        $mail_link=$request->mail_link;

        if ($mail_link !=null) {
            $userlink=loginlink::where('email', '=', $request->email)->where('mail_link', '=', $request->mail_link)->first();

            if ($user) {
                $user->update(['mail_link'=> null]);
                $tokenResult=$userlink->createToken('Access Token');
                return response()->json([ 'message'=> 'email is correct ','code'=> 200,'access_token'=> $tokenResult->accessToken]);
            }
            else {
                return response()->json([ 'code'=> 404,'message'=> ' Your mail is invalid'],404);
            }
        }
        else {
            return response()->json([ 'code'=> 404,'message'=> 'Link Cannot be null'],404);
        }
    }
}