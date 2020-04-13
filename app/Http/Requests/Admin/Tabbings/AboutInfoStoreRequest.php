<?php

namespace App\Http\Requests\Admin\Tabbings;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\Varchar;
use App\Rules\HTMLText;
use App\Rules\Image;

class AboutInfoStoreRequest extends FormRequest
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
            'name' => ['required', new Varchar],
            'label' => ['nullable', new Varchar],
            'description' => ['nullable', new HTMLText],
        ];

        return $rules;
    }
}
