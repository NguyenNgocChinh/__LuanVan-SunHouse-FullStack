<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Log;
use Session;

class FilterView
{
    private $session;
    public function __construct(Store $session)
    {
        $this->session = $session;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $posts = $this->getViewedPosts();
        Log::info("in middleware filter view");
        if (!is_null($posts))
        {
            Log::info("post is null");
            $posts = $this->cleanExpiredViews($posts);
            $this->storePosts($posts);
        }
        return $next($request);
    }

    private function getViewedPosts()
    {
        return $this->session->get('viewed_posts', null);
    }

    private function cleanExpiredViews($posts)
    {
        $time = time();

        // Let the views expire after one hour.
        $throttleTime = env('THROTTLE_TIME_VIEW', 60);

        return array_filter($posts, function ($timestamp) use ($time, $throttleTime)
        {
            return ($timestamp + $throttleTime) > $time;
        });
    }

    private function storePosts($posts)
    {
        $this->session->put('viewed_posts', $posts);
    }
}
