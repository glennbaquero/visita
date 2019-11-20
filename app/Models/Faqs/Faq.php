<?php

namespace App\Models\Faqs;
use App\Helpers\StringHelpers;

use App\Extenders\Models\BaseModel as Model;

class Faq extends Model
{


    const TYPE_VISITOR = 'VISITOR';
    const TYPE_DESTINATION_MANAGER = 'DESTINATION MANAGER';
    const TYPE_FRONTLINER = 'FRONTLINER';


    /**
     * @Setters
     */
    public static function store($request, $item = null, $columns = ['answer', 'question', 'type'])
    {
        $vars = $request->only($columns);

        if (!$item) {
            $item = static::create($vars);
        } else {
            $item->update($vars);
        }

        return $item;
    }


    /**
     * @Getters
     */
    public static function getTypes() {
        return [
            ['value' => static::TYPE_VISITOR, 'label' => 'VISITOR', 'class' => 'bg-info'],
            ['value' => static::TYPE_DESTINATION_MANAGER, 'label' => 'DESTINATION MANAGER', 'class' => 'bg-success'],
            ['value' => static::TYPE_FRONTLINER, 'label' => 'FRONTLINER', 'class' => 'bg-warning'],

        ];
    }

    /**
     * @Render
     */
    public function renderShowUrl($prefix = 'admin') {
        return route($prefix . '.faqs.show', $this->id);
    }

    public function renderArchiveUrl($prefix = 'admin') {
        return route($prefix . '.faqs.archive', $this->id);
    }

    public function renderRestoreUrl($prefix = 'admin') {
        return route($prefix . '.faqs.restore', $this->id);
    }
}
