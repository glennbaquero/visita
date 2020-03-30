<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

use App\Traits\FileTrait;
use App\Traits\ArrayFormatterTrait;

class Picture extends Model implements Sortable
{
    use FileTrait, ArrayFormatterTrait, SortableTrait;

    protected $guarded = [];

    public $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => true,
    ];

    public function parent() {
        return $this->morphTo();
    }

    public static function formatItem($item) {
        return [
            'id' => $item->id,
            'order_column' => $item->order_column,
            'path' => $item->renderImagePath(),
        ];
    }
}
