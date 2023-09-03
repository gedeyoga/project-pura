<?php

namespace App\Events;

use App\Models\SensorPintuLog;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SensorPintuOpen
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sensor_log;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(SensorPintuLog $sensor_log)
    {
        $this->sensor_log = $sensor_log;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
