<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\MenuItem;

class MenuItemCollection extends ResourceCollection
{
    public $collects = MenuItem::class;
}
