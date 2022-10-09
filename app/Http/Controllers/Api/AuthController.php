<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:255',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:5|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'data' => null,
                'error' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'])
        ]);

        return response()->json([
            'message' => 'Created',
            'data' => $user,
            'error' => null,
        ]);
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:dns',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'data' => null,
                'error' => $validator->errors()
            ], 422);
        }

        $credentials = $validator->validated();

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized',
                'data' => null,
                'error' => null,
            ]);
        }

        return response()->json([
            'message' => 'Login Successfully',
            'data' => [
                'token' => $token,
                'token_type' => 'bearer',
            ],
            'error' => null,
        ]);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json([
            'message' => 'Logout successfully',
            'data' => null,
            'error' => null,
        ]);
    }
}
