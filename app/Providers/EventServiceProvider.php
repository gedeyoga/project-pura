<?php

namespace App\Providers;

use App\Events\SensorPintuActive;
use App\Events\SensorPintuNotActive;
use App\Listeners\SensorPintuActiveListener;
use App\Listeners\SensorPintuNotActiveListener;
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

        SensorPintuActive::class => [
            SensorPintuActiveListener::class,
        ],
        SensorPintuNotActive::class => [
            SensorPintuNotActiveListener::class
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
