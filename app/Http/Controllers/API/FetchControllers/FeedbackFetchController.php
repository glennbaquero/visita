<?php

namespace App\Http\Controllers\API\FetchControllers;

use App\Extenders\Controllers\FetchController;

use App\Models\Feedbacks\Feedback;

class FeedbackFetchController extends FetchController
{
    /**
     * Set object class of fetched data
     * 
     * @return void
     */
    public function setObjectClass()
    {
        $this->class = new Feedback;
    }

    /**
     * Custom filtering of query
     * 
     * @param Illuminate\Support\Facades\DB $query
     * @return Illuminate\Support\Facades\DB $query
     */
    public function filterQuery($query)
    {
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
        	'question' => $item->question,
        	'answerable' => $item->answerable,
        	'show_other' => $item->show_other,
        	'others_placeholder' => $item->show_other ? $item->others_placeholder : null,
        	'answers' => $item->answerable ? $item->answers : null,
        	'remarks' => null,
        	'selected' => null
        ];
    }
}
