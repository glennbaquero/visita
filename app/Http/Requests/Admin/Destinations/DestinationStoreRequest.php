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
        $id = $this->route('id');
        $rules = [
            'name' => 'required',
            // 'code' => 'required',
            // 'icon' => 'required',
            'terms_conditions' => 'required',
            'visitor_policies' => 'required',
            'operating_hours' => 'required',
            'cut_off_days' => 'required',
            'orientation_module' => 'required',
            'capacity_per_day' => 'required',
            'overview' => 'required',
            'contact_us' => 'required',
            'fees' => 'required',
            'how_to_get_here' => 'required',
        ];

        if ($id) {
            $image = [
                'images.*' => 'mimes:jpeg,bmp,png,jpg'
            ];
        } else {
            $image = [
                'images.*' => 'required|mimes:jpeg,bmp,png,jpg'
            ];
        }

        $rules = array_merge($rules, $image);

        return $rules;
    }
}
