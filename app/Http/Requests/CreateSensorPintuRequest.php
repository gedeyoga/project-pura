<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSensorPintuRequest extends FormRequest
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
            'gs_nama' => 'required', 
            'pura_id' => 'required',
            'gs_sensor_pintu' => 'required',
            'guard_state' => 'required', 
            'token' => 'required',
        ];
    }
}
