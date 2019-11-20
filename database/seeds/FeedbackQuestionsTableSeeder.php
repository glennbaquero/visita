<?php

use Illuminate\Database\Seeder;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

use App\Imports\Feedbacks\FeedbackQuestionImport;

class FeedbackQuestionsTableSeeder extends Seeder
{
     /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::beginTransaction();

        Excel::import(new FeedbackQuestionImport, storage_path('imports/feedbacks_question.xls'));

        DB::commit();
    }
}
