<?php

namespace App\Events;

use App\Models\SensorPintu;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SensorPintuActive
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sensor_pintu;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(SensorPintu $sensor_pintu)
    {
        $this->sensor_pintu = $sensor_pintu;
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
