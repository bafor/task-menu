<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Ramsey\Uuid\Uuid;

class DeleteMenu extends Controller
{
    /** @var DeleteMenu */
    private $deleteMenu;

    public function __construct(
        DeleteMenu $deleteMenu
    )
    {
        $this->deleteMenu = $deleteMenu;
    }

    public function destroy($menu)
    {
        $this->deleteMenu->delete(Uuid::fromString($menu));
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
