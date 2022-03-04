<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmployeeMiddleware
{
    public function handle(Request $request, Closure $next): Closure|JsonResponse|Response
    {
        if ($request->user()->type != 'employee' && $request->user()->type != 'admin') {
            return new Response(
                content: null,
                status: Response::HTTP_UNAUTHORIZED
            );
        }
        return $next($request);
    }
}
