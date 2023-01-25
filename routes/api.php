<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loginController;
use App\Http\Controllers\emergencyleaveController;
use App\Http\Controllers\loginlinkController;






/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('requestlogin',[loginController::class,'requestpin']);
Route::post('verifylogin',[loginController::class,'verifypin']);
Route::post('requestloginlink',[loginlinkController::class,'link']);
Route::post('verifyloginlink',[loginlinkController::class,'verifylink']);


Route::middleware('auth:api')->group(function(){
Route::post('upload_document',[emergencyleaveController::class,'Leave_attechements']);  
Route::post('emergencyleave',[emergencyleaveController::class,'leave']);
Route::post('updatedetailes/{id}',[loginController::class,'update']);

});


