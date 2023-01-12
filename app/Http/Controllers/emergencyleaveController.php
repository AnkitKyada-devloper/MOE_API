<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emergencyleave;
use App\Models\Leave_attechements;
use Auth;
use Illuminate\Support\Facades\Validator;
use TheSeer\Tokenizer\Exception;


class emergencyleaveController extends Controller
{

  public function leave(Request $request)
  {
    try{
      $validated = Validator::make($request->all(),[
        'leave_type_id' => 'required|not_in:-- Choose Leave Type --',  
         'reason' => 'required|min:3|max:100',
        'fromDate1' => 'required',
        'toDate1' => 'required|after:fromDate1',
        'totalNoOfDays'=>'required',
       ]);
     
     if($validated->fails()){
      return response()->json(['Error' => 'something went wrong.', 'code' => 404], 404);
 }
      $leave = new Emergencyleave;
      $leave->register_user_id = Auth::user()->id;
      $leave->leave_type_id = $request->leave_type_id; //6<-Emergencyid
      $leave->reason = $request->reason;
      $leave->fromDate1 = $request->fromDate1;
      $leave->toDate1 = $request->toDate1;
      $leave->totalNoOfDays = $request->totalNoOfDays;
      $leave->pendingLeaves = $request->pendingLeaves;
      $leave->paidLeaves = $request->paidLeaves;
      $leave->lost_of_pay = $request->lost_of_pay;
      $leave->save();
      return response()->json(['message' => 'Success', 'code' => 200], 200);
  }
    catch (Exception $e) {
      return response()->json(['Error' => 'something went wrong.', 'code' => 500], 500);
  }
  }

  
      public function  Leave_attechements(Request $request)
  {
    try{
        $validated = Validator::make($request->all(),[
          'attechement_type_id'=>'required',
            'upload_document.*' => 'required|mimes:png,jpg,pdf,docx,excel,txt|max:2048'
          ]);
   if($validated->fails()){
        return response()->json(['Error' => 'something went wrong.', 'code' => 404], 404);
  }
     
          $leave1 = new Leave_attechements;
          $leave1->leave_id = Auth::user()->id;
          $leave1->attechement_type_id = $request->attechement_type_id;

          $upload_document = [];
          $files = $request->upload_document;

          foreach ($files as $file) {
                $data = $file->getClientOriginalName();
                $filename = time() . '_' . $data;
                $file->move('public/reports/', $filename);
                $upload_document[] = $filename;
                $leave1->upload_document = implode("\n", $upload_document);
                
                $leave1->save();
  }
      return response()->json(['message' => 'Success', 'code' => 200], 200);
  }
    catch (Exception $e) {
       return response()->json(['Error' => 'something went wrong.', 'code' => 500], 500);
  }
  }
  }