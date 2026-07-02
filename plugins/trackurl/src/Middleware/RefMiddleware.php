<?php

namespace Azuriom\Plugin\Trackurl\Middleware;

use Azuriom\Plugin\Trackurl\Models\Link;
use Closure;
use Illuminate\Http\Request;

class RefMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Only process requests to the root URL with a ref parameter
        if ($request->path() === '/' && $request->has('ref')) {
            $shortCode = $request->query('ref');

            if (!$shortCode) {
                return $next($request);
            }

            // Find the link by short code
            $link = Link::where('short_code', $shortCode)->first();

            if (!$link) {
                return $next($request);
            }

            // Redirect to the TrackurlController's redirectRef method to handle tracking
            return redirect()->route('trackurl.redirect', ['shortCode' => $shortCode]);
        }

        return $next($request);
    }
}
