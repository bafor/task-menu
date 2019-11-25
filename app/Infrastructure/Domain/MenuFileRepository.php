<?php declare(strict_types=1);

namespace App\Infrastructure\Domain;

use App\Domain\Menu;
use App\Domain\Menus;
use App\Exceptions\NotFound;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\UuidInterface;

class MenuFileRepository implements Menus
{
    public function getById(UuidInterface $menuId)
    {
        if (!Storage::disk('local')->exists($this->menuPath($menuId))) {
            throw new NotFound('Menu not found ' . $menuId->toString());
        }

        return unserialize(Storage::disk('local')->get($this->menuPath($menuId)), [Menu::class]);
    }

    public function save(Menu $menu): void
    {
        Storage::disk('local')->put($this->menuPath($menu->id()), serialize($menu));
    }

    public function delete(Menu $menu): void
    {
        if (!Storage::disk('local')->exists($this->menuPath($menu->id()))) {
            throw new NotFound('Menu not found ' . $menu->id()->toString());
        }
        Storage::disk('local')->delete($this->menuPath($menu->id()));
    }

    private function menuPath(UuidInterface $menu): string
    {
        return 'menus/' . $menu->toString();
    }
}
