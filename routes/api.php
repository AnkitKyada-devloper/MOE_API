<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Login;
use App\Models\Leave_attechements;
use Illuminate\Support\Facades\Auth;
use App\Models\Emergencyleave;
use App\Http\Controllers\loginController;
use App\Http\Controllers\emergencyleaveController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\API\MultipleUploadController;




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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('requestlogin',[loginController::class,'requestpin']);
Route::post('verifylogin',[loginController::class,'verifypin']);
Route::post('emergencyleave',[emergencyleaveController::class,'leave']);
Route::post('upload_document',[emergencyleaveController::class,'Leave_attechements']);
Route::post('updatedetailes/{id}',[loginController::class,'update']);