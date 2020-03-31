<?php

use Illuminate\Database\Seeder;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

use App\Imports\AnnualIncomes\AnnualIncomeImport;

class AnnualIncomesTableSeeder extends Seeder
{
      /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::beginTransaction();

        Excel::import(new AnnualIncomeImport, storage_path('imports/annualincomes.xls'));

        DB::commit();
    }
}
