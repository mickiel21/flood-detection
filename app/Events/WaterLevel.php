<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Support\Facades\Log;

class WaterLevel implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

 
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        Log::info("Dispatching event: WaterLevel");

        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        Log::info('Broadcasting on water-level channel');

        return new Channel('water-level');
    }

    public function broadcastAs()
    {
        return 'WaterLevel'; // Matches your Echo listener
    }

}

