<?php

namespace App\Listeners;

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
    public function handle(SensorPintuNotActive $event)
    {
        $pura = $event->sensor_pintu->pura;

        foreach ($pura->users as $user) {
            if (!is_null($user)) {
                $user->notify(new AlertDeviceNotification('Pemberitahuan', 'Sensor mati' , $pura));
            }
        }
    }
}
