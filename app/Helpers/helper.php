<?php
namespace App\Helpers;

class Helper{
    public static function success($message,$user)
    {
        return response()->json(['code' => 200,'message' => 'Successfully !..'.$message,'data'=>$user], 200);
    }
    public static function validated($validated)
    {
        return response()->json(['code' => 422,'message' => $validated->errors()], 422);
    }
  
    public static function catch()
    {
        return response()->json(['code' => 500,'message' => 'Error'], 500);
    }
    public static function error($message)
    {
        return response()->json(['code' => 404,'message' => 'Error !..'.$message], 404);
    }
}