<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserAuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if ($user->role != 'user') {
                return response()->json(['error' => 'forbidden resource'], 403);
            }
            $request->merge(['userId' => $user->id]);

            return $next($request);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
}
