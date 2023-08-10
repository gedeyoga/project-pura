<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePuraRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'pura_nama' => 'required|string', 
            'pura_alamat' => 'required|string', 
            'pura_lat' => 'required', 
            'pura_lng' => 'required', 
            'jp_id' => 'required', 
            'kel_id' => 'required', 
            'pura_ip' => 'required',
        ];
    }
}
