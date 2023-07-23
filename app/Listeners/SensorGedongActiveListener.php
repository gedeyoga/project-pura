<?php

namespace App\Listeners;

use App\Events\SensorGedongActive;
use App\Notifications\AlertDeviceNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SensorGedongActiveListener
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
    public function handle(SensorGedongActive $event)
    {
        $pura = $event->gedong_simpen->pura;

        foreach ($pura->users as $user) {
            if(!is_null($user)) {
                $user->notify(new AlertDeviceNotification('Pemberitahuan' , 'Sensor aktif' , $pura));
            }
        }
    }
}
