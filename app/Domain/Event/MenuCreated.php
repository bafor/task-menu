<?php

namespace App\Domain\Event;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MenuCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /** @var array */
    private $menu;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(array $menu)
    {
        $this->menu = $menu;
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

    public function menu(): array
    {
        return $this->menu;
    }

}
