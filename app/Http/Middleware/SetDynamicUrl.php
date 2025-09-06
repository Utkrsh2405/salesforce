<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class SetDynamicUrl
{
    public function handle(Request $request, Closure $next)
    {
        // Set the application URL dynamically based on the current request
        if ($request->header('host')) {
            $protocol = $request->isSecure() ? 'https' : 'http';
            $host = $request->header('host');
            URL::forceRootUrl("{$protocol}://{$host}");
        }

        return $next($request);
    }
}
