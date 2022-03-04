<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): JsonResponse|Closure
    {
        if ($request->user()->type != 'admin') {
            return new Response(
                content: ["message" =>'Unauthorized'],
                status: Response::HTTP_UNAUTHORIZED
            );
        }
        return $next($request);
    }
}
