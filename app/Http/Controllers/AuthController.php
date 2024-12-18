<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function login(Request $request): \Illuminate\Http\JsonResponse{
        $validator = validator($request->all(),[
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }
        //$request->validate();
        $credentials = request(['email', 'password']);
        $token = Auth::attempt($credentials);
        if(!$token){
            return response()->json([
                'error' => 'Unauthorized'
            ],401);
        }
        $user = Auth::user();
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => env('JWT_TTL') * 60,
            'user' => $user,
        ]);
    }

    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id'=> "0"
        ]);

        return response()->json([
            'message' => "User successfully registered",
            'user' => $user,
        ]);
    }

    public function me(): \Illuminate\Http\JsonResponse{
        return response()->json(Auth::user());
    }
    public function logout(): \Illuminate\Http\JsonResponse{
        Auth::logout();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function refresh(): \Illuminate\Http\JsonResponse{
        $user = Auth::user();
        return response()->json([
            'access_token' => Auth::refresh(),
            'token_type' => 'bearer',
            'expires_in' => env('JWT_TTL') * 60,
            'user' => $user,
        ]);
    }

}






//za
