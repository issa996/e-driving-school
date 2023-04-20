<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Http\Request;
use App\Http\Requests\SchoolRegisterRequest;
use App\Http\Requests\SchoolLoginRequest;
use App\Http\Requests\SchoolUpdateRequest;

use App\Models\Driving_school;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DrivingSchoolController extends Controller
{
    public function register(SchoolRegisterRequest $request){
        $validated = $request->validated();
        $school = Driving_school::create([
            'name' => $validated['name'],
            'phone_number' => $validated['phone_number'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'address' => $validated['address']
        ]);
        $school_token = $school->createToken('school_token', ['school'])->plainTextToken;
        return response()->json([
            'token' => $school_token,
            'message' => 'driving school has been registed',
            'status code' => 200

        ]);

    }
    public function login(SchoolLoginRequest $request){
        $validated = $request->validated();
        $school = Driving_school::where('email',$validated['email'])->first();
        if($school && Hash::check($validated['password'], $school->password)){
            $school_token = $school->createToken('school_token', ['school'])->plainTextToken;
            return response()->json([
                'token' => $school_token,
                'message' => 'the school has been logged in',
                'status code' => 200
            
            ]);
        }
        else{
            return response()->json([
                'message' => 'email or password is not correct',
                'status code' => 401

            ]);

        }


    }
    public function logout(Request $request){
        $request->user()->currentAccessToken('school')->delete();
        return response()->json([
            'message' => $request->user()->name.'school has been logged out'
        ]);

    }
    public function reset_password(ResetPasswordRequest $request){
        $validated = $request->validated();
        $school = Auth::user();
        if(!Hash::check($validated['old_password'],Auth::user()->password)){
           return response()->json([
            'message' => 'old password is not correct'
           ]);
        }
        else{
            Driving_school::find($school->id)->update([
                'password' => bcrypt($validated['new_password'])
            ]);
            return response()->json([
                'message' => 'password has been changed',
                'status code' => 200
            ]);
        }


    }
    public function information_update(SchoolUpdateRequest $request){
        $validated = $request->validated();
        $school = Auth::user();
        Validator::make($validated, [
            'email' => [
                'required',
                Rule::unique('driving_schools')->ignore($school->id),
            ],
        ]);
        Driving_school::find($school->id)->update([
            'name' => $validated['name'],
            'phone_number' => $validated['phone_number'],
            'email' => $validated['email'],
            'address' => $validated['address']
        ]);
        return response()->json([
            'message' => 'school information has been updated',
            'status code' => 200
            ]);

    }
}
