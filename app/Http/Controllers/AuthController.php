<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if(Auth::attempt($credentials)){
            $user = Auth::user();
            $token = $user->createToken('LaravelSanctum')->plainTextToken;
            return response()->json([
                'token' => $token,
                'message' => 'User Login successfully',
                'status' => 200,
                'sucess' => true
            ],200);
        }else{
            return response()->json([
                'message' => 'Invalid credentials',
                'status' => 401,
                'sucess' => false,
                'error' => 'Unauthorized'
            ],401);
        }
    }
   //Register Api
   public function register(Request $request)
   {
       try{
           $request->validate([
               'name' => 'required|string|max:255',
               'email' => 'required|string|email|max:255|unique:users',
               'phone' => 'required|string|max:20|unique:users',
               'password' => 'required|string|min:8',
           ]);
           $user = User::create([
               'name' => $request->name,
               'email' => $request->email,
               'phone' => $request->phone,
               'password' => Hash::make($request->password),
           ]);

           auth()->login($user);
           return response()->json([
               'message' => 'User Registerd successfully',
               'user' => $user,
               'status' => 200,
               'sucess' => true
           ], 200);
       }catch(\Exception $e){
           return response()->json([
               'message' => $e->getMessage(),
               'status' => 401,
               'sucess' => false,
               'error' => 'Unauthorized'
           ]);
       }
   }
   public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logged out successfully',
            'status' => 200,
            'success' => true,
        ],200);
   }
}
