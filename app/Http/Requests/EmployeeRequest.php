<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'email'  =>  [
                'required',
                'email',
                'unique:users'
            ],
            'image' =>  [
                'required',
                'image'
            ],
            'phone' =>  [
                'required',
                'numeric',
                'digits:10'
            ],
            'password' => [
                'required',
                'string',
                'min:6',
            ]
        ];

        if ($this->method() == 'PUT') {
            $rules['image'] = [
                'sometimes',
                'nullable',
                'image'
            ];

            $rules['password'] =  [
                'sometimes',
                'nullable',
                'email',
                'max:255'
            ];

            $rules['email'] =  [
                'required',
                'string',
                'email',
                'unique:users,id,'. request('id')
            ];

            $rules['active'] =  [
                'sometimes',
                'nullable',
                'int',
                'in:0,1',
            ];
        }

        return $rules;
    }
}
