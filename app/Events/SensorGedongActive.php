<?php

namespace App\Events;

use App\Models\GedongSimpen;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SensorGedongActive
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $gedong_simpen;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(GedongSimpen $gedong_simpen)
    {
        $this->gedong_simpen = $gedong_simpen;
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
