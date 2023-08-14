<?php

namespace App\Listeners;

use App\Events\SensorCctvNotActive;
use App\Events\SensorPintuNotActive;
use App\Notifications\AlertDeviceNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SensorPintuNotActiveListener
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
    public function handle(SensorCctvNotActive $event)
    {
        $pura = $event->sensor_cctv->pura;

        foreach ($pura->users as $user) {
            dd($user);
            if (!is_null($user)) {
                $user->notify(new AlertDeviceNotification('Pemberitahuan', 'Sensor mati' , $pura));
            }
        }
    }
}
