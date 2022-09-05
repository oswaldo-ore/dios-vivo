<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'ci'=>'required|numeric|unique:users,ci',
            'name' => 'required',
            'last_name'=>'required',
            'complement' => 'required',
            'email'=>'required|email',
            'password' => 'required|min:6|max:20',
            'rol_id' => 'required',
        ];
    }
}
