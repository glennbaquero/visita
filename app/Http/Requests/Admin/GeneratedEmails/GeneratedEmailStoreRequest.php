<?php

namespace App\Http\Requests\Admin\GeneratedEmails;

use Illuminate\Foundation\Http\FormRequest;

class GeneratedEmailStoreRequest extends FormRequest
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
            'notification_type' => 'required',
            'title' => 'required',
            'message' => 'required',
        ];
    }
}
