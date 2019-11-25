<?php declare(strict_types=1);

namespace App\Infrastructure\Domain;

use App\Domain\Menu;
use App\Domain\Menus;
use Ramsey\Uuid\UuidInterface;

class MenuViewEloquentRepository
{

    public function getById(UuidInterface $menuId)
    {
        return \App\Menu::findOrFail($menuId);
    }

    public function save(Menu $menu)
    {
        $data = $menu->toArray();

        throw new \Exception("not implemented yet");
    }
}
