<?php

namespace App\Http\Middleware\Jwt;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            if ($e instanceof TokenInvalidException) {
                return response()->json([
                    'message' => 'Invalid Token',
                    'data' => null,
                    'error' => null,
                ], 401);
            } else if ($e instanceof TokenExpiredException) {
                return response()->json([
                    'message' => 'Token is Expired',
                    'data' => null,
                    'error' => null,
                ]);
            } else {
                return response()->json([
                    'message' => 'Authorization Token not found',
                    'data' => null,
                    'error' => null,
                ]);
            }
        }

        return $next($request);
    }
}
