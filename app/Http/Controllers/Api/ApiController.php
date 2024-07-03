<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;



class ApiController extends Controller
{
    // Register API POST, FORM DATA
    public function register(Request $request)
{
    Log::info('Register request data:', $request->all());

    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
    ]);
    
    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    $token = JWTAuth::fromUser($user);

    return response()->json([
        'token' => $token,
        'user' => $user,
    ]);
}

    // Login API POST, FORM DATA
    public function login(Request $request){
        // Data validation
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);
    
        // JWTAuth and attempt
        $credentials = $request->only('email', 'password');
    
        if (!$token = JWTAuth::attempt($credentials)) { 
            return response()->json([
                "status" => false,
                "message" => "Invalid login details"
            ], 401);
        }
    
        // Response
        return response()->json([
            "status" => true,
            "message" => "User logged in",
            "token" => $token
        ]);
    }
    
    // Profile API GET
    public function profile(){
        $userData = auth()->user();

        return response()->json([
            "status" => true,
            "message" => "Profile Data",
            "user" => $userData
        ]);
    }

    // Refresh token API GET
    public function refreshToken(){
        $newToken = auth()-> refresh();

        return response()->json([
            "status" => true,
            "message" => "New Access token generated",
            "token" => $newToken
        ]);
        
    }

    // Logout API GET
    public function logout(){
        auth()->logout();

        return response()->json([
            "status" => true,
            "message" => "Logout Successful"
        ]);
    }
}