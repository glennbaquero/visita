<?php

namespace App\Http\Requests\Admin\Experiences;

use Illuminate\Foundation\Http\FormRequest;

class ExperienceStoreRequest extends FormRequest
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
            'destination_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'fee' => 'required',
        ];
    }

    public function messages() {
        return [
            'destination_id.required' => 'Please select a destination',
        ];
    }
}
