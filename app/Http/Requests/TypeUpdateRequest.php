<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TypeUpdateRequest extends FormRequest
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
            'type_name'=>'required|max:255',
            'title'=>'required|max:255',
            'slug'=>'required|max:255',
            'status'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'type_name.required'=>'Type name is empty',
            'type_name.max'=>'Length max 255',
            'title.required'=>'Title is empty',
            'title.max'=>'Length max 255',
            'slug.required'=>'Slug is empty'
        ];
    }
}
