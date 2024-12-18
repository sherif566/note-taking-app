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
        $start = microtime(true);

        $response = $next($request);

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

