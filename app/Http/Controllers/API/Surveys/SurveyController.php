<?php

namespace App\Http\Controllers\API\Surveys;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Surveys\Survey;
use App\Models\Surveys\SurveyExperience;
use DB;

class SurveyController extends Controller
{
    public function answer(Request $request)
    {
    	$survey_vars = $request->only(['survey']);
    	$survey_experience = $request->only(['survey_answers']);
    	DB::beginTransaction();
    		$survey = Survey::create($survey_vars['survey']);
    		foreach ($survey_experience['survey_answers']['data'] as $key => $data) {
	    		$survey->surveyExperienceAnswers()->create([
	    			'survey_experience_data' => json_encode($data),
                    'answer' => $data['selected'],
	    			'remarks' => $data['remarks']
	    		]);
    		}


    	DB::commit();

    	return response()->json([
    		'message' => 200
    	]);
    }
}
