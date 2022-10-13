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

  public function store(array $data): User
  {
    $validator = Validator::make($data, [
      'name' => 'required|min:3|max:255',
      'email' => 'required|email:dns|unique:users',
      'password' => 'required|min:5|max:255',
    ]);

    if ($validator->fails()) {
      throw new ValidationException($validator);
    }

    return $this->userRepository->create($data);
  }

  public function authenticate(array $credentials): string
  {
    $validator = Validator::make($credentials, [
      'email' => 'required|email:dns',
      'password' => 'required'
    ]);

    if ($validator->fails()) {
      throw new ValidationException($validator);
    }

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
