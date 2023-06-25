<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBook extends FormRequest
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
            'author' => 'bail|required|min:4',
            'category' => 'bail|required|min:4',
            // 'control_number' => 'bail|required|min:3|unique:books',
            'publication_date' => 'bail|required|date',
        ];
    }
}
