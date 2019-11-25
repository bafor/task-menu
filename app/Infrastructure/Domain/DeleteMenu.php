<?php declare(strict_types=1);

namespace App\Infrastructure\Domain;

use App\Domain\Event\MenuDeleted;
use App\Domain\Menus;
use Ramsey\Uuid\UuidInterface;

class DeleteMenu
{
    /** @var Menus */
    private $menus;

    public function __construct(Menus $menus)
    {
        $this->menus = $menus;
    }

    public function delete(UuidInterface $menuId): void
    {
        $menu = $this->menus->getById($menuId);
        $this->menus->delete($menu);

        event(new MenuDeleted($menuId));
    }
}
