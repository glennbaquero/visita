<?php

namespace App\Imports\Carousels;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use App\Helpers\StringHelpers;

use App\Models\Carousels\HomeBanner;


class HomeBannerImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
    	foreach ($rows as $row) {

            $item = HomeBanner::where('name',$row['name'])->first();

            if($item) {
                $item->forceDelete();
            }

    		HomeBanner::create([
    			'name' => $row['name'],
                'link_label' => $row['link_label'],
                'link' => $row['link'],
                'image_path' => $row['image_path']
    		]);
    	}
    }
}
