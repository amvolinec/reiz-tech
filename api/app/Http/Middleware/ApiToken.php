<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiToken
{
    const API_TOKEN = 'api_token';

    const UNAUTHORIZED = 'Unauthorized';

    public function handle(Request $request, Closure $next): Response
    {
        if ($request->get(self::API_TOKEN) != config(key: 'auth.api_token')) {
            return response()->json(self::UNAUTHORIZED, 401);
        }

        return $next($request);
    }
}
