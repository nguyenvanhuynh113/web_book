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
        return [
            'category_name'=>'required|unique:categories|max:255',
            'title'=>'required|max:255',
            'slug'=>'required|max:255',
            'status'=>'required',
        ];
    }
    public function messages()
    {
       return [
            'category_name.required'=>'Category name is empty',
            'category_name.max'=>'Length max 255',
           'category_name.unique'=>'Category name is already exist',
           'title.required'=>'Title is empty',
           'title.max'=>'Length max 255',
           'slug.required'=>'Slug is empty'
       ];
    }
}
