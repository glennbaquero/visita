<?php

use Illuminate\Database\Seeder;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

use App\Imports\SurveyExperiences\SurveyExperienceAnswerImport;

class SurveyExperienceAnswersTableSeeder extends Seeder
{
      /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::beginTransaction();

        Excel::import(new SurveyExperienceAnswerImport, storage_path('imports/survey_experience_answers.xls'));

        DB::commit();
    }
}
