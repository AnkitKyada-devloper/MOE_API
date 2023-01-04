<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emergencyleave;

class emergencyleaveController extends Controller
{
    public function leave(Request $request){
        $validated = $request->validate([
                  'leave_type'=> 'required|not_in:-- Choose Leave Type --',
                   'reason' => 'required|min:3|max:100',
                    'start_date' => 'required',
                      'end_date' =>'required|after:start_date',
                       'upload_document' => 'required|mimes:png,jpg,pdf,docx,excel'
                   ]);

          $leave = new Emergencyleave;
          $leave->leave_type = $request->leave_type;
          $leave->reason =$request->reason;
          $leave->start_date =$request->start_date;
          $leave->end_date =$request->end_date;
        
          if ($request->hasfile('upload_document')) {
            $file = $request->file('upload_document');
            $data = $file->getClientOriginalName();
            $filename = time() . '.' . $data;
            $file->move('public/reports/', $filename);
            $leave->upload_document = $filename;
          } 
          $leave->save();
          return response()->json(['message' => 'success' ,'code' =>200],200);
      }
}
