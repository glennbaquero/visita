<?php

namespace App\Http\Controllers\Admin\Surveys;

use App\Extenders\Controllers\FetchController;

use App\Models\Surveys\Survey;
use App\Models\Surveys\SurveyAnswer;

class SurveyAnswerFetchController extends FetchController
{
      /**
     * Set object class of fetched data
     * 
     * @return void
     */
    public function setObjectClass()
    {
        $this->class = new SurveyAnswer;
    }

    /**
     * 
     * @param Illuminate\Support\Facades\DB $query
     * @return Illuminate\Support\Facades\DB $query
     */
    public function filterQuery($query)
    {
        if ($this->request->filled('surveyid')) {
            $query = $query->where('survey_id', $this->request->input('surveyid'));
        }

        return $query;
    }

    /**
     * Custom formatting of data
     * 
     * @param Illuminate\Support\Collection $items
     * @return array $result
     */
    public function formatData($items)
    {
        $result = [];

        foreach($items as $item) {
            $data = $this->formatItem($item);
            array_push($result, $data);
        }

        return $result;
    }

    /**
     * Build array data
     * 
     * @param  App\Contracts\AvailablePosition
     * @return array
     */
    protected function formatItem($item)
    {
        return [
            'id' => $item->id,
            'survey_id' => $item->survey_id,
            'question' =>json_decode($item->survey_experience_data)->question,
            'answer' => $item->answer,
            'remarks' => $item->remarks,
            'created_at' => $item->renderDate(),
            'showUrl' => $item->renderShowUrl(),
            'archiveUrl' => $item->renderArchiveUrl(),
            'restoreUrl' => $item->renderRestoreUrl(),
            'deleted_at' => $item->deleted_at,
        ];
    }

    public function fetchView($id = null) {
        $item = null;

        if ($id) {
        	$item = SurveyAnswer::withTrashed()->findOrFail($id);
            $item->archiveUrl = $item->renderArchiveUrl();
            $item->restoreUrl = $item->renderRestoreUrl();
        }

    	return response()->json([
    		'item' => $item,
            'answers' => $answers 
    	]);
    }
}
