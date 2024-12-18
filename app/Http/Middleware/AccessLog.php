<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class AccessLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Log incoming request
        $start = microtime(true);

        // Process the request and get the response
        $response = $next($request);

        // Log access details
        $duration = round((microtime(true) - $start) * 1000, 2);
        Log::info('Access Log', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'status' => $response->status(),
            'duration_ms' => $duration,
            'params' => $request->all(),
        ]);

        return $response;
    }
}

