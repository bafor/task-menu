<?php

namespace App\View;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ramsey\Uuid\UuidInterface;

class Item extends Model
{
    public    $incrementing = false;
    protected $keyType      = 'string';
    public    $timestamps   = false;

    public static function fromArray(UuidInterface $menuId, array $data)
    {
        $item               = new self();
        $item->menu_id      = $menuId;
        $item->id           = $data['id'];
        $item->max_depth    = $data['max_depth'];
        $item->max_children = $data['max_children'];
        $item->field        = $data['field'];

        $item->save();

        $item->children()->saveMany(
            array_filter(
                array_map(
                    function (array $data) use ($menuId) {
                        return Item::fromArray($menuId, $data);
                    }, $data['children']
                )
            )
        );

        return $item;
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'owner_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
