<?php

namespace App\Http\Requests;

use App\Rules\UppercaseWithNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string',
            'email' => [
                'required',
                'string',
                Rule::unique('users')->ignore($this->id),
            ],
            'role' => 'required|string',
            'phone' => 'required|string|min:10',

        ];

        if($this->get('change_password')) {
            $rules['password'] = [
                'required',
                'string',
                'min:8',
                new UppercaseWithNumber()
            ];
        }

        return $rules;
    }
}
