<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(UserRequest $request) {

        $user = User::create($request->validated());

        $token = $user->createToken('auth_token')->accessToken;

        return response()->json(['token' => $token],201);
    }

    public function login(UserLoginRequest $request) {
        $user = User::where('email', $request->input('email'))->first();

        if(!$user) {
            return response()->json('Invalid email',401);
        }   

        if(!Hash::check($request->input('password'), $user->password)) {
            return response()->json('Invalid password',401);
        }

        $token = $user->createToken('auth_token')->accessToken;

        return response()->json(['token' => $token],200);
        
    }

    public function show() {
            if(Auth::guard('api')->check()) {
                $user = Auth::guard('api')->user();
                return response()->json(['user' => $user],200);
            }  

    }

    public function logout(UserLoginRequest $request) {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'User logout'],200);
    }
}