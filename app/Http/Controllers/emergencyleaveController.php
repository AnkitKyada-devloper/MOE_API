<?php
namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Models\Emergencyleave;
use App\Models\Leave_attechements;
use TheSeer\Tokenizer\Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Encryption\DecryptException;

class emergencyleaveController extends Controller
{

    public function leave(Request $request)
    {

        try {

            $validated = Validator::make(
                $request->all(),
                [
                    'leave_type_id' => 'required|not_in:-- Choose Leave Type --',
                    'reason' => 'required',
                    'fromDate1' => 'required',
                    'toDate1' => 'required|same:fromDate1',
                    'totalNoOfDays' => 'required',
                    'pendingLeaves' => 'nullable',
                    'paidLeaves' => 'nullable',
                    'lost_of_pay' => 'nullable'
                ]
            );

            if ($validated->fails()) {
                return Helper::validated($validated);
            }

            $leave = new Emergencyleave;
            $leave->register_user_id = 1;
            $leave->leave_type_id = $request->leave_type_id; //6<-Emergencyid
            $leave->reason = $request->reason;
            $leave->fromDate1 = $request->fromDate1;
            $leave->toDate1 = $request->toDate1;
            $leave->totalNoOfDays = $request->totalNoOfDays;
            $leave->pendingLeaves = $request->pendingLeaves;
            $leave->paidLeaves = $request->paidLeaves;
            $leave->lost_of_pay = $request->lost_of_pay;
            $leave->save();
            $encrypted = Crypt::encryptString($leave->id);

            return Helper::successData('Insert Leave', $encrypted);
        } catch (Exception $e) {
            return Helper::catch ();
        }
    }
    public function leaveAttechements(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                'attechement_type_id' => 'required',
                'upload_document.*' => 'required|mimes:png,jpg,pdf',
                'location_latitude' => 'required',
                'location_longitude' => 'required'
            ]);

            if ($validated->fails()) {
                return Helper::validated($validated);
            }


            $upload_document = [];
            $files = $request->upload_document;
            $leave_id = $request->leave_id;
            $decrypted = Crypt::decryptString($leave_id);

            $user_id = Auth::user()->id;
            $path = "reports/";
            $slash = "/";
            $url = $path . $user_id . $slash . $decrypted;

            foreach ($files as $file) {

                $leave1 = new Leave_attechements;
                $leave1->leave_id = $decrypted;
                $leave1->attechement_type_id = $request->attechement_type_id;
                $leave1->location_latitude = $request->location_latitude;
                $leave1->location_longitude = $request->location_longitude;

                $data = $file->getClientOriginalName();
                $filename = time() . '_' . $data;
                $file->move($url, $filename);
                $leave1->upload_document = $url . $filename;
                $leave1->save();
            }
            return Helper::success('Leave atteched');
        } catch (Exception $e) {
            return Helper::catch ();
        }
    }
    public function getLeave(Request $request)
    {
        try {
            $user_id = $request->id;
            $decrypted_id = Crypt::decryptString($user_id);
            $userleave = DB::table('emergencyleaves')->select('emergencyleaves.id','register_users.first_name', 'register_users.last_name', 'emergencyleaves.*')
                ->join('register_users', 'register_users.id', '=', 'emergencyleaves.register_user_id')
                ->where('emergencyleaves.register_user_id', $decrypted_id)
                ->orderBy('id','DESC')
                ->get();

            $query = Emergencyleave::where('register_user_id', $decrypted_id)->first();

            if ($query) {
                return Helper::successData('Get Data', $userleave);
            } else {
                return Helper::error('Data not found');
            }
        } catch (Exception $e) {
            return response()->json(['code' => 500, 'message' => 'Error'], 500);
        }
    }
    
    

}