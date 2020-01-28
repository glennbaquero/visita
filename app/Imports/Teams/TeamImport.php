<?php

namespace App\Imports\Teams;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use App\Helpers\StringHelpers;

use App\Models\Pages\Team;


class TeamImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
    	foreach ($rows as $row) {

            $item = Team::where('name',$row['name'])->first();

            if($item) {
                $item->forceDelete();
            }

    		Team::create([
    			'type' => $row['type'],
                'name' => $row['name'],
                'designation' => $row['designation'],
                'description' => $row['description'],
                'image_path' => $row['image_path']
    		]);
    	}
    }
}
