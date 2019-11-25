<?php

namespace App\View;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Ramsey\Uuid\Uuid;

class Menu extends Model
{
    public    $incrementing = false;
    protected $keyType      = 'string';
    public    $timestamps   = false;

    public function root(): HasOne
    {
        return $this->hasOne(Item::class, 'owner_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class, 'menu_id');
    }

    public static function saveFromArray(array $data): void
    {
        $menuId = Uuid::fromString($data['id']);

        $menu               = new self();
        $menu->id           = $data['id'];
        $menu->max_depth    = $data['max_depth'];
        $menu->max_children = $data['max_children'];
        $menu->save();

        $root               = new Item();
        $root->id           = Uuid::uuid4();
        $root->menu_id      = $menuId;
        $root->field        = 'root';
        $root->max_depth    = $data['max_depth'];
        $root->max_children = $data['max_children'];

        $root->owner()->associate($menu);
        $root->save();

        $root->children()->saveMany(
            array_map(
                function (array $data) use ($menuId) {
                    return Item::fromArray($menuId, $data);
                }, $data['children']
            )
        );

        $menu->save();
    }

}
