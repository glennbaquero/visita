<?php

namespace App\Http\Requests\API\Masungi;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceStoreRequest extends FormRequest
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
            'trail_name' => 'required',
            'start_time' => 'required',
            'scheduled_at' => 'required',
            'total_guest' => 'required|min:7',
            'trail_data' => 'required',
            'guests.*' => 'required',
            'conservation_fee' => 'required|numeric',
            'transaction_fee' => 'required|numeric',
            'sub_total' => 'required|numeric',
            'grand_total' => 'required|numeric',
             
        ];
    }

    public function messages() {
        return [
            'trail_name.required' => 'Please select a trail first.',
            'start_time' => 'Please select your start time for your visit.',
            'scheduled_at' => 'Please select your schedule for your visit.',
            'total_guest' => 'Total guest is required.',
            'trail_data' => 'Trail data is required.',
            'conservation_fee.required' => 'Conservation Fee is required.',
            'conservation_fee.numeric' => 'Conservation Fee must be a number.',
            'transaction_fee.required' => 'Transaction Fee is required.',
            'transaction_fee.numeric' => 'Transaction Fee must be a number.',
            'sub_total.required' => 'Sub Total is required.',
            'sub_total.numeric' => 'Sub Total must be a number.',
            'grand_total.required' => 'Grand Total is required.',
            'grand_total.numeric' => 'Grand Total must be a number.',
        ];
    }
}
