<?php

namespace App\Providers;

use App\Events\SensorGedongActive;
use App\Events\SensorGedongNotActive;
use App\Listeners\SensorGedongActiveListener;
use App\Listeners\SensorGedongNotActiveListener;
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
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        SensorGedongActive::class => [
            SensorGedongActiveListener::class,
        ],
        SensorGedongNotActive::class => [
            SensorGedongNotActiveListener::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
