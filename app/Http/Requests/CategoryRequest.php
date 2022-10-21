<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:200',
            'description' => 'required|string|min:3|max:700',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name is required. Please fill in.',
            'description.required' => 'The description is required. Please fill in.',
        ];
    }
}
