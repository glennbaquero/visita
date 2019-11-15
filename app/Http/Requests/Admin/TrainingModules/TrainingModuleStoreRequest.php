<?php

namespace App\Http\Requests\Admin\TrainingModules;

use Illuminate\Foundation\Http\FormRequest;

class TrainingModuleStoreRequest extends FormRequest
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
            'title' => 'required',
            'destination_id' => 'required',
            'description' => 'required',
        ];
    }

    public function messages() {
        return [
            'destination_id.required' => 'Please select a destination',
        ];
    }
}
