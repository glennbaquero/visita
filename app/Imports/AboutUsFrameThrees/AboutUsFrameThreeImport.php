<?php

namespace App\Imports\AboutUsFrameThrees;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use App\Helpers\StringHelpers;

use App\Models\Pages\AboutUsFrameThree;


class AboutUsFrameThreeImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
    	foreach ($rows as $row) {

            $item = AboutUsFrameThree::where('title',$row['title'])->first();

            if($item) {
                $item->forceDelete();
            }

    		AboutUsFrameThree::create([
    			'title' => $row['title'],
                'description' => $row['description'],
                'image_path' => $row['image_path']
    		]);
    	}
    }
}
