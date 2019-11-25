<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\View\Menus;
use Ramsey\Uuid\Uuid;

class ShowMenu extends Controller
{
    /** @var Menus */
    private $menus;

    public function __construct(Menus $menus)
    {
        $this->menus = $menus;
    }

    public function show($menu)
    {
        return $this->menus->getById(Uuid::fromString($menu));
    }
}
