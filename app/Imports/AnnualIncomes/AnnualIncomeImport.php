<?php

namespace App\Imports\AnnualIncomes;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use App\Helpers\StringHelpers;

use App\Models\AnnualIncomes\AnnualIncome;

class AnnualIncomeImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
    	foreach ($rows as $row) {
    		AnnualIncome::updateOrCreate([
    			'name' => $row['name'],
    		], [
	            'name' => $row['name'],
	            'order' => $row['order'],
    		]);
    	}
    }
}
	