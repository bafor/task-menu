<?php

namespace App\Http\Controllers;

use App\Infrastructure\Domain\MenuCreateParams;
use App\Infrastructure\Domain\MenuCreator;
use App\View\Menus;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class CreateMenu extends Controller
{
    /** @var MenuCreator */
    private $creator;
    /** @var Menus */
    private $menus;

    public function __construct(MenuCreator $creator, Menus $menus)
    {
        $this->creator = $creator;
        $this->menus   = $menus;
    }

    public function create(Request $request)
    {
        $menuId = Uuid::uuid4();
        $this->creator->build(MenuCreateParams::fromArray($menuId, $request->json()->all()));

        return $this->menus->getById($menuId)
            ->response()
            ->setStatusCode(201);
    }

}
