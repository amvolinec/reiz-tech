<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ApiToken
{
    public function handle(Request $request, Closure $next): Response
    {
        Log::debug('ApiToken middleware: ' . $request->api_token);

        if ($request->api_token != config(key: 'auth.api_token')) {
            Log::debug('ApiToken middleware: Unauthorized');

            return response()->json('Unauthorized', 401);
        }

        Log::debug('ApiToken middleware: Authorized');
        return $next($request);
    }
}
