<?php

namespace App\Events;

use App\DTO\CurrencyWebSocketDTO;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Log;

class HistoricalEvent implements ShouldBroadcast {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public CurrencyWebSocketDTO $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(CurrencyWebSocketDTO $data) {
        $this->data = $data;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn() {
        return new Channel('historical-data');
    }

    public function broadcastWith() {
        return [
            'data' => $this->data,
        ];
    }
}
