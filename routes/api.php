<?php

use App\Http\Controllers\DrivingStudentController;
use App\Http\Controllers\DrivingSchoolController;
use App\Http\Controllers\QuestionController;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//Route::post('/school/register',[DrivingSchoolController::class,'register']);
Route::post('/register',[DrivingStudentController::class,'register']);
Route::post('/login',[DrivingStudentController::class,'login']);
Route::post('hi',[QuestionController::class,'add_question']);
Route::group(['prefix' => 'student','middleware' => ['auth:sanctum','abilities:student']],function(){
    Route::post('/logout',[DrivingStudentController::class,'logout']);
    Route::post('reset_password',[DrivingStudentController::class,'reset_password']);
    Route::post('update/{student}',[DrivingStudentController::class,'information_update']); 
    Route::post('registerwithschool/{school}',[DrivingStudentController::class,'registerwithschool']);


});
Route::group(['prefix' => 'school'],function(){
    Route::post('/register',[DrivingSchoolController::class,'register']);
    Route::post('/login',[DrivingSchoolController::class,'login']);
    

});
Route::group(['prefix' => 'school', 'middleware' => ['auth:sanctum','abilities:school']] ,function(){
    Route::post('/reset_password',[DrivingSchoolController::class,'reset_password']);
    Route::post('update',[DrivingSchoolController::class,'information_update']);
});





