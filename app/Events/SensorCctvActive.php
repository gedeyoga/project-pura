<?php

namespace App\Events;

use App\Models\SensorCctv;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SensorCctvActive
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sensor_cctv;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(SensorCctv $sensor_cctv)
    {
        $this->sensor_cctv = $sensor_cctv;
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
