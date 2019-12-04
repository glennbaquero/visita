<?php

namespace App\Http\Requests\Admin\Managements;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\Varchar;

class ManagementStoreRequest extends FormRequest
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
            // 'role_id' => 'required',
            'destination_id' => 'required',
            'first_name' => ['required', new Varchar],
            'last_name' => ['required', new Varchar],
            'email' => 'required|email',
            'contact_number' => 'required',
        ];

        if ($id) {
            $emailRules = [
                'email' => 'required|email|unique:managements,email,' . $id,
                'username' => 'required|unique:managements,username,' . $id,
            ];
        } else {
            $emailRules = [
                'email' => 'required|email|unique:managements,email',
                'username' => 'required|unique:managements,username',
            ];
        }

        $rules = array_merge($rules, $emailRules);

        return $rules;

    }

    public function messages() {
        return [
            // 'role_id.required' => 'Please select a role',
            'destination_id.required' => 'Please select a destination',
        ];
    }
}

