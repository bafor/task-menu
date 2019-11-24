<?php declare(strict_types=1);

namespace App\Infrastructure\Domain;

use App\Domain\Menu;
use App\Domain\Menus;
use Ramsey\Uuid\UuidInterface;

class MenuFileRepository implements Menus
{

    public function getById(UuidInterface $menuId)
    {
        throw new \Exception("not implemented yet");
    }

    public function save(Menu $menu)
    {
        throw new \Exception("not implemented yet");
    }
}
