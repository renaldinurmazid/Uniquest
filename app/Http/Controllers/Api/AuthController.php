<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required',
                'password' => 'required',
            ]);

            $login = $request->email;

            $user = User::where('email', $login)
                ->orWhereHas('studentProfile', function($query) use ($login) {
                    $query->where('npm', $login);
                })
                ->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Invalid credentials',
                ], 401);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user->load('studentProfile'),
            ]);
        }catch(Exception $e){    
            Log::error($e->getMessage());
            return response()->json([
                'message' => 'Login failed',
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try{
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'message' => 'Logout successful',
            ]);
        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json([
                'message' => 'Logout failed',
            ], 500);
        }
    }

    public function me(Request $request)
    {
        try{
            return response()->json([
                'message' => 'User data',
                'user' => $request->user()->load('studentProfile'),
            ]);
        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json([
                'message' => 'Failed to get user data',
            ], 500);
        }
    }
}
