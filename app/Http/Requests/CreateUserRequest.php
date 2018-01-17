<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'name' => ['required', 'min:3'],
            'last_name' => ['required', 'min:3'],
            'id' => 'required',
        ];
    }

    public function messages()
    {
        return [
          'name.min' => 'Escriba un nombre correcto.',
          'last_name.min' => 'Escriba un apellido correcto.',
        ];
    }
}
