<?php

namespace App\Providers;

use App\Models\BaiDang;
use App\Models\User;
use App\Observers\BaiDangObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use SocialiteProviders\Manager\SocialiteWasCalled;
use App\Events\ViewPostHandler;
use App\Listeners\ViewPostHanlderListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SocialiteWasCalled::class => [
            // ... other providers
            'SocialiteProviders\\Google\\GoogleExtendSocialite@handle',
            'SocialiteProviders\\Facebook\\FacebookExtendSocialite@handle',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(
            ViewPostHandler::class,
            [ViewPostHanlderListener::class, 'handle']
        );
        Event::listen('posts.view', 'App\Demo\Events\ViewPostHandler');
        User::observe(UserObserver::class);
        BaiDang::observe(BaiDangObserver::class);
    }
}
