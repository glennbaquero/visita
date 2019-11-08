<?php

namespace App\Models\Inquiries;

use App\Extenders\Models\BaseModel as Model;

class Inquiry extends Model
{
    /**
     * @Render
     */
    public function renderShowUrl($prefix = 'admin') {
        $route = $this->id;

        if ($prefix == 'web') {
            $route = [$this->id, $this->slug];
        }

        return route($prefix . '.inquiries.show', $route);
    }

    public function renderArchiveUrl($prefix = 'admin') {
        return route($prefix . '.inquiries.archive', $this->id);
    }

    public function renderRestoreUrl($prefix = 'admin') {
        return route($prefix . '.inquiries.restore', $this->id);
    }


    public function renderWebHome() {
        return route('web.home');
    }

    /**
     * @Setters
     */
    public static function store($request, $item = null, $columns = ['fullname', 'contact_number', 'email', 'purpose', 'message'])
    {
        $vars = $request->only($columns);
        
        if (!$item) {
            $item = static::create($vars);
        } else {
            $item->update($vars);
        }

        return $item;
    }
}
