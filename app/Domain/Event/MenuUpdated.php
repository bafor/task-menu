<?php

namespace App\Domain\Event;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MenuUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var array */
    private $menu;

    public function __construct(array $menu)
    {
        $this->menu = $menu;
    }

    public function menu(): array
    {
        return $this->menu;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
