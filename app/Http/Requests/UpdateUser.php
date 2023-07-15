<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest
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
            'avatar' => 'image|mimes:jpg,jpeg,gif,png,svg|max:2000',
            'name' => 'bail|required|min:4',
            // 'password'=> 'confirmed',
            'address' => 'bail|required|min:5',
        ];
    }
}
