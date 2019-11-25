<?php declare(strict_types=1);

namespace App\View;

use App\Http\Resources\MenuItemCollection;
use App\View\Model\Menu as MenuView;
use Ramsey\Uuid\UuidInterface;

interface Menus
{
    public function getById(UuidInterface $menuId): MenuView;

    public function getMenuItems(UuidInterface $menuId): MenuItemCollection;

    public function refreshViewModel(array $menu): void;

    public function removeViewModel(UuidInterface $menuId): void;
}
