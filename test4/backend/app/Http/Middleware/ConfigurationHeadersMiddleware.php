<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ConfigurationHeadersMiddleware
{
    private $unwantedHeaderList = [
        'X-Powered-By',
        'Server',
    ];

    public function handle(Request $request, Closure $next){
        $this->removeUnwantedHeaders($this->unwantedHeaderList);
        $response = $next($request);
        // $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Referrer-Policy', 'no-referrer-when-downgrade');
        $response->headers->set('X-XSS-Protection', '0; mode=block'); // Anti cross site scripting (XSS)
        $response->headers->set('X-Content-Type-Options', 'nosniff'); // Reduce exposure to drive-by dl attacks
            // Don't cache stuff (we'll be updating the page frequently)
        $response->headers->set('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains', true);
        $response->headers->set('X-Permitted-Cross-Domain-Policies', 'master-only');
        $response->headers->set('Pragma', 'no-cache');

        // $response->withHeaders([
        //     'X-Frame-Options' => 'SAMEORIGIN',
        //     'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains',
        //     'Cache-Control' => 'no-cache, no-store, must-revalidate, post-check=0, pre-check=0',
        //     'Pragma' => 'no-cache',
        // ]);
        return $response;
    }

    private function removeUnwantedHeaders($headerList)
    {
        foreach ($headerList as $header)
            header_remove($header);
    }
}

