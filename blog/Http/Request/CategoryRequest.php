<?php

namespace Blog\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title'=>'required|string|min:2|max:200'
        ];
    }
}
