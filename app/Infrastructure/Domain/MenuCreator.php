<?php declare(strict_types=1);

namespace App\Infrastructure\Domain;

use App\Domain\Event\MenuCreated;
use App\Domain\Menu;
use App\Domain\Menus;

class MenuCreator
{
    /** @var Menus */
    private $menus;

    public function __construct(Menus $menus)
    {
        $this->menus = $menus;
    }

    public function build(MenuCreateParams $createParams): void
    {
        $menu = new Menu(
            $createParams->id(),
            $createParams->maxDepth(),
            $createParams->maxChildren()
        );
        $menu->addItem($createParams->field());

        $this->menus->save($menu);

        event(new MenuCreated($menu->toArray()));
    }
}
