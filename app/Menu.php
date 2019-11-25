<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    public    $incrementing = false;
    protected $keyType      = 'string';
    public    $timestamps   = false;

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public static function saveFromArray(array $data): void
    {
        $menu              = new self();
        $menu->id          = $data['id'];
        $menu->max_depth    = $data['max_depth'];
        $menu->max_children = $data['max_children'];

        $menu->save();

        $menu->items()->saveMany(
            array_map(
                function (array $data) use ($menu) {
                    return Item::fromArray($menu, $data);
                }, $data['children']
            )
        );

        $menu->save();
    }

}
