<?php

namespace App\Imports\Tabbings;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use App\Helpers\StringHelpers;

use App\Models\Tabbings\AboutInfo;


class AboutInfoImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
    	foreach ($rows as $row) {

            $item = AboutInfo::where('name',$row['name'])->first();

            if($item) {
                $item->forceDelete();
            }

    		AboutInfo::create([
    			'name' => $row['name'],
                'label' => $row['label'],
                'description' => $row['description']
    		]);
    	}
    }
}
