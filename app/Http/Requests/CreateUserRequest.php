<?php

namespace App\Http\Requests;

use App\Rules\UppercaseWithNumber;
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
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'role' => 'required|string',
            'phone' => 'required|string|min:10',
            'password' => [
                'required',
                'string',
                'min:8',
                new UppercaseWithNumber()
            ],
            
        ];
    }
}
