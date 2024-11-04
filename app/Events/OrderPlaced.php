<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class OrderPlaced implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $order;
    /**
     * Create a new event instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('pop-channel'),
        ];
    }
    public function broadcastAs(){
        return 'new-order-notification';
    }
    public function broadcastWith()
    {
        return [
            'id' => $this->order->id,
            'pickup_location' => $this->order->pickup_location,
            'delivery_location' => $this->order->delivery_location,
            'size' => $this->order->size,
            'weight' => $this->order->weight,
            'pickup_datetime' => $this->order->pickup_datetime,
            'delivery_datetime' => $this->order->delivery_datetime,
            'status' => $this->order->status,
        ];
    }
    
}
