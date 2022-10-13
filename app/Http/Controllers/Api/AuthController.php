<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

    public function register(Request $request)
    {
        try {
            $user = $this->service->store($request->all());
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'data' => null,
                'error' => $e->errors()
            ], 400);
        }

        return response()->json([
            'message' => 'Register Successfully',
            'data' => $user,
            'error' => null,
        ], 201);
    }

    public function login(Request $request)
    {
        try {
            $token = $this->service->authenticate($request->all());
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'data' => null,
                'error' => $e->errors(),
            ], 400);
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
