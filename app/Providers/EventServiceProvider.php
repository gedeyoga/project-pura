<?php

namespace App\Providers;

use App\Events\SensorCctvActive;
use App\Events\SensorCctvNotActive;
use App\Events\SensorPintuActive;
use App\Events\SensorPintuNotActive;
use App\Events\SensorPintuOpen;
use App\Listeners\SensorPintuActiveListener;
use App\Listeners\SensorPintuNotActiveListener;
use App\Listeners\SensorPintuOpenListener;
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

        SensorCctvActive::class => [
            SensorPintuActiveListener::class,
        ],
        SensorCctvNotActive::class => [
            SensorPintuNotActiveListener::class
        ],

        SensorPintuOpen::class => [
            SensorPintuOpenListener::class
        ]
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
