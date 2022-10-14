<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    private AuthService $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function register(RegisterUserRequest $request)
    {
        $validatedData = $request->validated();
        $this->service->store($validatedData);
        return response()->json([
            'message' => 'Register Successfully',
            'data' => null,
            'error' => null,
        ], 201);
    }

    public function login(LoginUserRequest $request)
    {
        $validatedData = $request->validated();

        try {
            $token = $this->service->authenticate($validatedData);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unauthorized',
                'data' => null,
                'error' => $e->getMessage()
            ], 401);
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
        $this->service->logout();

        return response()->json([
            'message' => 'Logout Successfully',
            'data' => null,
            'error' => null,
        ]);
    }
}
