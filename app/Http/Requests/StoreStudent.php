<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudent extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'bail|required|min:4',
            'email' => 'bail|required|min:3|email|unique:users',
            'password'=> 'bail|required|confirmed|min:6',
            'student_number' => 'bail|required|min:3|integer|unique:students',
            'year' => 'bail|required|integer',
            'address' => 'bail|required|min:5',
        ];
    }
}
