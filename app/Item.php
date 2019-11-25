<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    public    $incrementing = false;
    protected $keyType      = 'string';
    public    $timestamps   = false;

    public static function fromArray(Menu $menu, array $data)
    {
        $item = new self();
        $item->menu()->associate($menu);
        $item->id          = $data['id'];
        $item->max_depth    = $data['max_depth'];
        $item->max_children = $data['max_children'];
        $item->field       = $data['field'];

        $item->save();

        $item->children()->saveMany(
            array_filter(
                array_map(
                    function (array $data) use ($menu) {
                        return Item::fromArray($menu, $data);
                    }, $data['children']
                )
            )
        );

        return $item;
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
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
