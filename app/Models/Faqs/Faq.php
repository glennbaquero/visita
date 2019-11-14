<?php

namespace App\Models\Faqs;

use App\Extenders\Models\BaseModel as Model;

class Faq extends Model
{
    /**
     * @Setters
     */
    public static function store($request, $item = null, $columns = ['answer', 'question'])
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
