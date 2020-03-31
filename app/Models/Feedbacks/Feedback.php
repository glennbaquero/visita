<?php

namespace App\Models\Feedbacks;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Answers\Answer;

class Feedback extends Model
{
    public $table = "feedbacks";

    public function answers()
    {
    	return $this->morphMany(Answer::class, 'answerable');
    }

    /**
     * @Setters
     */
    public static function store($request, $item = null, $columns = ['question', 'answerable'])
    {
        $vars = $request->only($columns);

        $vars['answerable'] = $request->answerable ? true : false;

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
        return route($prefix . '.feedbacks.show', $this->id);
    }

    public function renderArchiveUrl($prefix = 'admin') {
        return route($prefix . '.feedbacks.archive', $this->id);
    }

    public function renderRestoreUrl($prefix = 'admin') {
        return route($prefix . '.feedbacks.restore', $this->id);
    }

    public function renderQuestion() {
    	return str_limit($this->question, 20);
    }
}
