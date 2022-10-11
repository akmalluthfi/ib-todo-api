<?php

namespace App\Services;

use Exception;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthService
{
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

    $user = User::create([
      'name' => $data['name'],
      'email' => $data['email'],
      'password' => Hash::make($data['password'])
    ]);

    return $user;
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
