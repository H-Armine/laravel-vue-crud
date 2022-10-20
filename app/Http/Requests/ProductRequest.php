<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $path = explode('/', request()->path());
        return [
            'id' => end($path) === 'edit' ? 'required' : '',
            'name' => 'required|string|min:3|max:35',
            'category_id' => 'required|integer',
            'price' => 'required|regex:/^[0-9](\.[0-9][0-9][0-9])$/',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name is required. Please fill in.',
            'category_id.required' => 'The category is required. Please fill in.',
            'price.required' => 'The price is required. Please fill in.',
        ];
    }
}
