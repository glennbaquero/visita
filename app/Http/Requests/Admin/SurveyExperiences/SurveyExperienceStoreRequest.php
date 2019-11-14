<?php

namespace App\Http\Requests\Admin\SurveyExperiences;

use Illuminate\Foundation\Http\FormRequest;

class SurveyExperienceStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'question' => 'required',
        ];
        
        // $rules = [
        //     'question' => 'required',
        // ];  

        // if ($this->show_other == 'on'){

        //     $rules['show_other'] = 'required';

        // }else if ($this->answerable == 'on') {

        //     $rules['answerable'] = 'required';

        // }else if ($this->answerable == 'off' && $this->show_other == 'off'){

        //     $rules['answerable'] = 'required';
        //     $rules['show_other'] = 'required';

        // }

        // return $rules;
    }


}


