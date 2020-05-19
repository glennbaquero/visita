<?php

namespace App\Models\Surveys;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Answers\Answer;

class SurveyExperience extends Model
{

    protected $table = 'survey_experiences';
    
	/*
	 * Relationship
	 */

    public function answers()
    {
    	return $this->morphMany(Answer::class, 'answerable');
    }

    /**
     * @Setters
     */
    public static function store($request, $item = null, $columns = ['question', 'others_placeholder'])
    {
        $vars = $request->only($columns);

        $vars['show_other'] = $request->show_other ? true : false;
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
        return route($prefix . '.survey-experiences.show', $this->id);
    }

    public function renderArchiveUrl($prefix = 'admin') {
        return route($prefix . '.survey-experiences.archive', $this->id);
    }

    public function renderRestoreUrl($prefix = 'admin') {
        return route($prefix . '.survey-experiences.restore', $this->id);
    }

    public function renderQuestion() {
    	return str_limit($this->question, 20);
    }

}
