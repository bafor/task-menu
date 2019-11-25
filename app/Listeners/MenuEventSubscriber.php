<?php

namespace App\Listeners;

use App\Domain\Event\MenuCreated;
use App\Domain\Event\MenuDeleted;
use App\Domain\Event\MenuUpdated;
use App\View\Menus;
use Illuminate\Events\Dispatcher;

class MenuEventSubscriber
{
    /** @var Menus */
    private $menus;

    public function __construct(Menus $menus)
    {
        $this->menus = $menus;
    }

    public function onMenuCreated(MenuCreated $event)
    {
        $this->menus->refreshViewModel($event->menu());
    }

    public function onMeneUpdated(MenuUpdated $event)
    {
        $this->menus->refreshViewModel($event->menu());
    }

    public function onMenuDeleted(MenuDeleted $event)
    {
        $this->menus->removeViewModel($event->menuId());
    }

    public function subscribe(Dispatcher $events)
    {
        $events->listen(
            MenuCreated::class,
            self::class . '@onMenuCreated'
        );

        $events->listen(
            MenuUpdated::class,
            self::class . '@onMenuUpdated'
        );

        $events->listen(
            MenuDeleted::class,
            self::class . '@onMenuDeleted'
        );
    }
}
