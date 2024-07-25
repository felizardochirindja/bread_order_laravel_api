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
        } catch (TokenInvalidException $e) {
            return response()->json(
                ['status' => 'token invalido']
            );
        } catch (TokenExpiredException) {
            return response()->json(
                ['status' => 'token expirado']
            );
        } catch (JWTException) {
            return response()->json(
                ['status' => 'token nao encontrado']
            );
        }

        return $next($request);
    }
}
