<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name'  =>  [
                'required',
                'string'
            ],
            'active' =>  [
                'required',
                'int',
                'in:0,1',
            ],
            'image' =>  [
                'required',
                'image'
            ],
            'description' =>  [
                'sometimes',
                'nullable',
                'string'
            ],
            'price' =>  [
                'required',
                'numeric',
                'min:1'
            ],
            'category_id' =>  [
                'required',
                'int',
                'exists:categories,id'
            ],
        ];

        if ($this->method() == 'PUT') {
            $rules['image'] = [
                'sometimes',
                'nullable',
                'image'
            ];
        }

        return $rules;
    }
}
