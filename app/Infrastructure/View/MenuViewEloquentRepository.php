<?php declare(strict_types=1);

namespace App\Infrastructure\View;

use App\Exceptions\NotFound;
use App\Http\Resources\MenuItemCollection;
use App\View\Menu;
use App\View\Menus;
use App\View\Model\Menu as MenuView;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\UuidInterface;

class MenuViewEloquentRepository implements Menus
{

    public function getById(UuidInterface $menuId): MenuView
    {
        try {
            return new MenuView(Menu::findOrFail($menuId));
        } catch (ModelNotFoundException $e) {
            throw new NotFound('menu not found');
        }
    }

    public function removeViewModel(UuidInterface $menuId): void
    {
        DB::table('menus')->delete($menuId);
    }

    public function refreshViewModel(array $menu): void
    {
        try {
            DB::beginTransaction();
            DB::table('menus')->delete($menu['id']);
            Menu::saveFromArray($menu);
            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw new \Exception('refreshing view model fail');
        }
    }

    public function getMenuItems(UuidInterface $menuId): MenuItemCollection
    {
        try {
            return new MenuItemCollection(Menu::findOrFail($menuId)->root->children);
        } catch (ModelNotFoundException $e) {
            throw new NotFound('menu not found');
        }
    }
}
