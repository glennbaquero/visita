<?php

namespace App\Http\Requests\Admin\Users;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\Varchar;
use App\Rules\Image;

class UserStoreRequest extends FormRequest
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
            'first_name' => ['required', new Varchar],
            'last_name' => ['required', new Varchar],
            'image_path' => ['nullable', new Image],
        ];

        if ($id) {
            $emailRules = [
                'email' => 'required|email|unique:users,email,' . $id,
            ];
        } else {
            $emailRules = [
                'email' => 'required|email|unique:users,email',
            ];
        }

        $rules = array_merge($rules, $emailRules);

        return $rules;
    }
}
