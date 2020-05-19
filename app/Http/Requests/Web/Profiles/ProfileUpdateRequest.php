<?php

namespace App\Http\Requests\Web\Profiles;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\Varchar;
use App\Rules\Image;

class ProfileUpdateRequest extends FormRequest
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
            'first_name' => ['required', new Varchar],
            'last_name' => ['required', new Varchar],
            'contact_no' => ['required'],
            // 'old_password' => ['required'],
            // 'password' => ['required', 'confirmed', 'min:8'],
        ];
    }

    public function messages() {
        return [
            'first_name.required' => 'The firstname is required',
            'last_name.required' => 'The lastname is required',
            'contact_no.required' => 'The contact number is required',
        ];
    }
}
