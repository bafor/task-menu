<?php

namespace App\Domain\Event;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Ramsey\Uuid\UuidInterface;

class MenuDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var UuidInterface */
    private $menuId;

    public function __construct(UuidInterface $menuId)
    {
        $this->menuId = $menuId;
    }

    public function menuId(): UuidInterface
    {
        return $this->menuId;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
