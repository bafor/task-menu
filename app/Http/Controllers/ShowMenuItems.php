<?php

namespace App\Http\Controllers;

use App\Http\Resources\MenuItemCollection;
use App\View\Menus;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class ShowMenuItems extends Controller
{
    /** @var Menus */
    private $menus;

    public function __construct(Menus $menus)
    {
        $this->menus = $menus;
    }

    public function showItems($menu)
    {
        return $this->menus->getMenuItems(Uuid::fromString($menu));
    }

}
