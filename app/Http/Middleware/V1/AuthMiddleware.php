<?php

namespace App\Http\Middleware\V1;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthMiddleware
{
   public function handle(Request $request, Closure $next): Response
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (TokenInvalidException) {
            return response()->json([
                'status' => 'ERROR',
                'message' => 'invalid access token',
            ]);
        } catch (TokenExpiredException) {
            return response()->json([
                'status' => 'ERROR',
                'message' => 'expired access token',
            ]);
        } catch (JWTException) {
            return response()->json([
                'status' => 'ERROR',
                'message' => 'access token not found',
            ]);
        }

        return $next($request);
    }
}
