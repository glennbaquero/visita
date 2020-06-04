<?php

namespace App\Http\Requests\Admin\Timeslots;

use Illuminate\Foundation\Http\FormRequest;

class TimeslotStoreRequest extends FormRequest
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
            'allocation_id' => 'required',
            'time' => 'required',
        ];
    }

    public function messages() {
        return [
            'allocation_id.required' => 'Please select an experience',
        ];
    }
}
