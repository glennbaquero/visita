<?php

namespace App\Http\Controllers\Admin\Surveys;

use App\Extenders\Controllers\FetchController;

use App\Models\Surveys\Survey;
use App\Models\Surveys\SurveyAnswer;


class SurveyFetchController extends FetchController
{
     /**
     * Set object class of fetched data
     * 
     * @return void
     */
    public function setObjectClass()
    {
        $this->class = new Survey;
    }

    /**
     * 
     * @param Illuminate\Support\Facades\DB $query
     * @return Illuminate\Support\Facades\DB $query
     */
    public function filterQuery($query)
    {
        $admin = auth()->guard('admin')->user();
        if($admin->destination_id) {
            $id = $admin->destination_id;
            $query = $query->whereHas('book', function($query) use($id){
                $query->where('destination_id', $id);
            });
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

        $admin = auth()->guard('admin')->user();

        foreach($items as $item) {
            // if($admin->destination_id) {
                // if($item->book->destination_id === $admin->destination_id) {
                    // array_push($result,[
                    //     'id' => $item->id,
                    //     'book_id' => $item->renderName(),
                    //     'age' => $item->age,
                    //     'gender' => $item->gender,
                    //     'nationality' => $item->nationality,
                    //     'created_at' => $item->renderDate(),
                    //     'showUrl' => $item->renderShowUrl(),
                    //     'archiveUrl' => $item->renderArchiveUrl(),
                    //     'restoreUrl' => $item->renderRestoreUrl(),
                    //     'deleted_at' => $item->deleted_at,
                    // ]);
                // } else {
                    $data = $this->formatItem($item);
                    array_push($result, $data);
                // }
            // }
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
            'book_id' => $item->renderName(),
            'age' => $item->age,
            'gender' => $item->gender,
            'nationality' => $item->nationality,
            'created_at' => $item->renderDate(),
            'showUrl' => $item->renderShowUrl(),
            'archiveUrl' => $item->renderArchiveUrl(),
            'restoreUrl' => $item->renderRestoreUrl(),
            'deleted_at' => $item->deleted_at,
        ];
    }

    public function fetchView($id = null) {
        $item = null;
        $answers = [];

        if ($id) {
        	$item = Survey::withTrashed()->findOrFail($id);
            $item->group = $item->renderName();
            $answers = $item->answers;
            $item->archiveUrl = $item->renderArchiveUrl();
            $item->restoreUrl = $item->renderRestoreUrl();
        }

    	return response()->json([
    		'item' => $item,
            'answers' => $answers 
    	]);
    }
}
