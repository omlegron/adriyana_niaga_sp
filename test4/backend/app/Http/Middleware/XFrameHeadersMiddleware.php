<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class XFrameHeadersMiddleware
{

    public function handle(Request $request, Closure $next){
        $response = $next($request);
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
        $response->headers->set('Pragma', 'no-cache');
        
        return $response;
    }
}

