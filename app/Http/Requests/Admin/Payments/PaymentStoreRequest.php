<?php

namespace App\Http\Requests\Admin\Payments;

use Illuminate\Foundation\Http\FormRequest;

class PaymentStoreRequest extends FormRequest
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
        $required = 'required|';
        $unique = 'unique:payments,code';
        if($id) {
            $required = '';
            $unique = '';
        }
        return [
            'image_path' => $required.'image',
            'code' => 'required|'.$unique,
            'name' => 'required',
            'type' => 'required',
            'fixed_amount' => 'numeric',
            'percentage_amount' => 'numeric',
        ];
    }

    public function messages() 
    {
        return [
            'image_path.required' => 'Payment method image is required.', 
            'code.required' => 'Payment method code is required.', 
            'code.unique' => 'Payment method code must be a unique code from existing.', 
            'name.required' => 'Payment method name is required.', 
            'type.required' => 'Transaction type is required.', 
        ];
    }
}
