<?php

namespace App\Http\Requests\Admin\Destinations;

use Illuminate\Foundation\Http\FormRequest;

class DestinationStoreRequest extends FormRequest
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
            'name' => 'required',
            'code' => 'required',
            'icon' => 'required',
            'terms_conditions' => 'required',
            'visitor_policies' => 'required',
            'operating_hours' => 'required',
            'orientation_module' => 'required',
            'capacity_per_day' => 'required',
            'description' => 'required',
            'contact_us' => 'required',
        ];
    }
}
