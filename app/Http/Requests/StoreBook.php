<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBook extends FormRequest
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
            'quantity' => 'bail|required|integer',
            'publication_date' => 'bail|required|date',
        ];
    }
}
