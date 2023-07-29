<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
            'name'=>'required|max:255|string',
            'title'=>'required|max:255|string',
            'slug'=>'required|max:255|string',
            'content'=>'required',
            'author'=>'required',
            'status'=>'required',
            'category'=>'required',
            'type'=>'required',
            'book_photo'=>'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
    public function messages()
    {
        return [

        ];
    }
}
