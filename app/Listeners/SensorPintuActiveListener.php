<?php

namespace App\Listeners;

use App\Events\SensorCctvActive;
use App\Events\SensorPintuActive;
use App\Notifications\AlertDeviceNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SensorPintuActiveListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(SensorCctvActive $event)
    {
        $pura = $event->sensor_cctv->pura;

        foreach ($pura->users as $user) {
            if(!is_null($user)) {
                $user->notify(new AlertDeviceNotification('Pemberitahuan' , 'Sensor aktif' , $pura));
            }
        }
    }
}