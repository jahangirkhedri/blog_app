<?php

namespace Blog\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title'=>'required|string|min:2',
            'description' => 'required|string|min:2',
            'categories'=>'required|array',
            'categories.*'=>'required|exists:categories,id',
        ];
    }
}
