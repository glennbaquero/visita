<?php

namespace App\Http\Controllers\API\FetchControllers;

use App\Extenders\Controllers\FetchController;

use App\Models\TrainingModules\TrainingModule;

class TrainingModuleFetchController extends FetchController
{
    /**
     * Set object class of fetched data
     * 
     * @return void
     */
    public function setObjectClass()
    {
        $this->class = new TrainingModule;
    }

    /**
     * Custom filtering of query
     * 
     * @param Illuminate\Support\Facades\DB $query
     * @return Illuminate\Support\Facades\DB $query
     */
    public function filterQuery($query)
    {
    	$user = auth()->guard('api')->user();

    	$query = $query->where('destination_id', $user->destination_id);

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
            'title' => $item->title,
            'description' => $item->description,
            'short_description' => str_limit($item->description, 15),
            'type' => $item->type,
            'path' => url($item->renderFilePath('path')),
        ];
    }
}
