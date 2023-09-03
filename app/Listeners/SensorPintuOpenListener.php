<?php

namespace App\Listeners;

use App\Events\SensorPintuOpen;
use App\Models\MessageLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SensorPintuOpenListener
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
    public function handle( SensorPintuOpen $event)
    {

        if($event->sensor_log->sensor_pintu) {
            if($event->sensor_log->sensor_pintu->pura) {
                $pura = $event->sensor_log->sensor_pintu->pura;

                $users = $pura->users;

                $message_logs = collect();
                $users->each(function($user) use ($event , $message_logs) {
                    if(!is_null($user->phone)) {
                        $message_logs->push([
                            'modelable_id' => $event->sensor_log->id,
                            'modelable_type' => get_class($event->sensor_log),
                            'phone' => $user->phone,
                            'message' =>  $event->sensor_log->sensor_pintu->gs_nama . ' telah dibuka pada ' . $event->sensor_log->created_at->format('Y/m/d H:i:s'),
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]);
                    }
                });

                MessageLog::insert($message_logs->toArray());
            }
        }
    }
}
