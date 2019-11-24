<?php

namespace App\Domain;

use Ramsey\Uuid\UuidInterface;

interface Menus
{
    public function getById(UuidInterface $menuId);

    public function save(Menu $menu);
}
