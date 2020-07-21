<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UserAddedToGroupEvent::class=>[
            \App\Listeners\IncreaseUserGroupCount::class,
        ],
        PaymentVerifiedEvent::class=>[
            \App\Listeners\PaymentVerifiedListener::class,
        ],
        MoveUserToWaitListEvent::class=>[
            \App\Listeners\MoveUserToWaitListListener::class,
        ],
        PopulateGroupEvent::class=>[
            \App\Listeners\PopulateGroupListener::class,
        ],
        PopulateOldGroupEvent::class=>[
            \App\Listeners\PopulateOldGroupListener::class,
        ],
        CheckWaitListEvent::class=>[
            \App\Listeners\CheckWaitListListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
