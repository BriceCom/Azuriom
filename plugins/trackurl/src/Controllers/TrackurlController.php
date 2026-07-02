<?php

namespace Azuriom\Plugin\Trackurl\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Trackurl\Models\Click;
use Azuriom\Plugin\Trackurl\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class TrackurlController extends Controller
{
    /**
     * Maximum number of clicks allowed per session in the time window
     */
    protected const MAX_CLICKS_PER_SESSION = 10;

    /**
     * Time window for rate limiting in minutes
     */
    protected const RATE_LIMIT_WINDOW = 5;

    /**
     * Display the index page.
     */
    public function index()
    {
        return view('trackurl::index');
    }

    /**
     * Redirect to the destination URL and record the click.
     */
    public function redirect(Request $request, string $shortCode)
    {
        $link = Link::where('short_code', $shortCode)->firstOrFail();

        return $this->processRedirect($request, $link);
    }

    /**
     * Redirect to the destination URL using the ref query parameter and record the click.
     */
    public function redirectRef(Request $request)
    {
        $shortCode = $request->query('ref');

        if (!$shortCode) {
            abort(404);
        }

        $link = Link::where('short_code', $shortCode)->firstOrFail();

        return $this->processRedirect($request, $link);
    }

    /**
     * Process the redirection for a link.
     */
    protected function processRedirect(Request $request, Link $link)
    {
        // Check if the link is blocked
        if ($link->blocked) {
            return response()->view('trackurl::blocked', [], Response::HTTP_FORBIDDEN);
        }

        // Check for rate limiting
        if ($this->isRateLimited($request)) {
            return response()->view('trackurl::rate-limited', [
                'minutes' => self::RATE_LIMIT_WINDOW
            ], Response::HTTP_TOO_MANY_REQUESTS);
        }

        // Record the click
        Click::create([
            'link_id' => $link->id,
            'session_id' => $request->session()->getId(),
            'user_agent' => $request->userAgent(),
            'created_at' => now(),
        ]);

        // Redirect to the destination URL
        return redirect()->away($link->destination_url);
    }

    /**
     * Check if the request is rate limited.
     */
    protected function isRateLimited(Request $request): bool
    {
        $sessionId = $request->session()->getId();
        $cacheKey = "trackurl_clicks:{$sessionId}";

        // Get current click count for this session
        $clickCount = Cache::get($cacheKey, 0);

        // If the session has exceeded the rate limit, return true
        if ($clickCount >= self::MAX_CLICKS_PER_SESSION) {
            return true;
        }

        // Increment the click count and set the cache with an expiration time
        Cache::put($cacheKey, $clickCount + 1, now()->addMinutes(self::RATE_LIMIT_WINDOW));

        return false;
    }
}
