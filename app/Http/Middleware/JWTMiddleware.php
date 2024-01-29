<?php

namespace App\Http\Middleware;

use App\Exceptions\AppError;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\{JWTException, TokenInvalidException, TokenExpiredException};

class JWTMiddleware {
    public function handle(Request $request, Closure $next) {
        try {
            JWTAuth::parseToken()->authenticate();
            return $next($request);
        } catch (JWTException $error) {

            if($error instanceof TokenInvalidException){
                throw new AppError('Token inválido', 498);
            }

            if($error instanceof TokenExpiredException){
                throw new AppError('Token expirado', 401);
            }

            $errorMessage = $error->getMessage() ?: 'Unauthorized';

            throw new AppError($errorMessage, 500);
            
            // return response()->json([
            //     throw new AppError($error->getMessage(), 500)
            // ]);
        }

    }
}