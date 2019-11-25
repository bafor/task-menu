<?php declare(strict_types=1);

namespace App\Infrastructure\Domain;

use App\Domain\Menu;
use App\Domain\Menus;
use Ramsey\Uuid\UuidInterface;

class MenuFileRepository implements Menus
{

    public function getById(UuidInterface $menuId)
    {
        ///
        ///
//        return Menu::fromArray(json_decode(true,))
    }

    public function save(Menu $menu)
    {
        /// json_encode($menu->toArray());

        // aassume that i serailizie it and store somwhere
        return;
    }
}
