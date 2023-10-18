<?php

namespace App\Listeners;

use App\Events\SensorCctvActive;
use App\Events\SensorPintuActive;
use App\Notifications\AlertDeviceNotification;
use App\Traits\NotificationTrait;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SensorPintuActiveListener
{

    use NotificationTrait;
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
        $cctv = $pura->sensor_cctv()->orderByDesc('id')->first();

        $data = $cctv->toArray();

        $data['cctv_photo'] = url($data['cctv_photo']);
        $data['created_at'] = $cctv->created_at->format('Y-m-d H:i');
        $data['pura'] = $pura->toArray();

        if($this->checkNotificationCctv($pura)) {
            foreach ($pura->users as $user) {
                if (!is_null($user)) {
                    $user->notify(new AlertDeviceNotification('Pemberitahuan', 'Sensor aktif', $data));
                }
            }
        }
    }
}
