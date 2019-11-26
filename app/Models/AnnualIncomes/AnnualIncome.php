<?php

namespace App\Models\AnnualIncomes;

use App\Extenders\Models\BaseModel as Model;

class AnnualIncome extends Model
{
    /**
     * @Setters
     */
    public static function store($request, $item = null, $columns = ['name'])
    {
        $vars = $request->only($columns);
        $vars['order'] = 0;

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
        return route($prefix . '.annual_incomes.show', $this->id);
    }

    public function renderArchiveUrl($prefix = 'admin') {
        return route($prefix . '.annual_incomes.archive', $this->id);
    }

    public function renderRestoreUrl($prefix = 'admin') {
        return route($prefix . '.annual_incomes.restore', $this->id);
    }

    public function renderName() {
    	return $this->name;
    }
}
