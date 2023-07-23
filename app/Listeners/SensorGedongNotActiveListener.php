<?php

namespace App\Listeners;

use App\Events\SensorGedongNotActive;
use App\Notifications\AlertDeviceNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SensorGedongNotActiveListener
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
    public function handle(SensorGedongNotActive $event)
    {
        $pura = $event->gedong_simpen->pura;

        foreach ($pura->users as $user) {
            if (!is_null($user)) {
                $user->notify(new AlertDeviceNotification('Pemberitahuan', 'Sensor mati' , $pura));
            }
        }
    }
}
