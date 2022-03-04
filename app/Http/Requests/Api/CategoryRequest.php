<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            ]
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
