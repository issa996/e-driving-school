<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRegisterRequest;
use App\Http\Requests\StudentLoginRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\Driving_school;
use App\Models\Driving_student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DrivingStudentController extends Controller
{
    public function register(StudentRegisterRequest $request){
        $validated = $request->validated();
        $student = Driving_student::create([
            'full_name' => $validated['full_name'],
            'mobile_number' =>$validated['mobile_number'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'student_address' => $validated['student_address']
        ]);
        $student_token = $student->createToken('student_token',['student'])->plainTextToken;
        return response()->json([
            'student_token' => $student_token,
            'message' => 'student has been registed',
            'status code' => 200
        ]);

        

    }
    public function login(StudentLoginRequest $request){
        $validated = $request->validated();
        $student = Driving_student::where('email',$validated['email'])->first();
        if($student && Hash::check($validated['password'],$student->password)){
            $student_token = $student->createToken('student_token',['student'])->plainTextToken;
        return response()->json([
            'student_token' => $student_token,
            'message' => 'student has been logged in',
            'status code' => 200
           
            ]);
        }
        else{
            return response()->json([
                'message' => ' email or password is not correct',
                'status code' => 401 
        ]);
        }

    }
    public function logout(Request $request){
        $request->user()->currentAccessToken('student')->delete();
        return response()->json([
            'message' => 'student has been logged out'
        ]);

    }
    public function reset_password(ResetPasswordRequest $request){
        $validated = $request->validated();
        $user = Auth::user();
        if(!Hash::check($validated['old_password'],Auth::user()->password)){
            return response()->json([
                'message' => 'the old password is not correct'
            ]);

        }
        else{
            Driving_student::where('id',$user->id)->update([
                'password' => bcrypt($validated['new_password'])
            ]);
            return response()->json([
                'message' => 'password has been changed',
                'status code' => 200
            ]);
        }
    }
    public function information_update(Driving_student $student,StudentUpdateRequest $request){
        $validated = $request->validated();
        Validator::make($validated, [
            'email' => [
                Rule::unique('driving_students')->ignore($student->id),
            ],
        ]);
        $student->update([
            'full_name' => $validated['full_name'],
            'mobile_number' =>$validated['mobile_number'],
            'email' => $validated['email'],
            'student_address' => $validated['student_address']

        ]);
        return response()->json([
            'message' => 'the driving student informations has been updated',
            'status code' => 200 


        ]);
    }
    public function registerwithschool( $school_id,Request $request){
        $school = Driving_school::find($school_id);
        $student = Driving_student::find(auth()->user()->id);
        $school->driving_students()->save($student);
        $message = 'you are registed in '. $school->name. 'Congrats';
        return response()->json([
            'message' => $message,
            'status code' => 200 


        ]);


    }
}
