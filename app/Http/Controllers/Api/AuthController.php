<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    #account creation/registration
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'gender' => 'required',
            'address' => 'required'            
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'gender' => $request->gender, 
            'address' => $request->address, 

        ]);

        if($user){
            return response()->json([
                'status' => true,
                'message' => 'You have registered successfully.',
                'user' => $user 
            ], 201);
        }

        return response()->json([
            'status' => false
        ], 409);

    }
    #user login
    public function login (Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $credentials = $request->only('username','password');

        if(!$token = auth()->guard('api')->attempt($credentials)){
            return response()->json([
                'success' => false,
                'message' => 'You have typed wrong Username or Password'
            ], 401);
        }

        return response()->json([
            'status' => true,
            'user' => auth()->guard('api')->user(),
            'token' => $token
        ], 200);
    }

    public function logout(){
        $removeToken = JWTAuth::invalidate(JWTAuth::getToken());

        if($removeToken){
            return response()->json([
                'status' => true,
                'message' => 'You have been logged out.'
            ], 200);
        }
    }
}