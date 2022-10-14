<?php

namespace App\Services;

use Exception;
use App\Models\User;
use App\Repositories\UserRepository;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthService
{

  private UserRepository $userRepository;

  public function __construct()
  {
    $this->userRepository = new UserRepository;
  }

  public function store(array $data)
  {
    $this->userRepository->create($data);
  }

  public function authenticate(array $credentials): string
  {
    if (!$token = JWTAuth::attempt($credentials)) {
      throw new Exception('These credentials do not match our records.');
    }

    return $token;
  }

  public function logout(): void
  {
    auth()->logout();
  }
}
