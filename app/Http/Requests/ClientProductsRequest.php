<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientProductsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id'    =>  [
                'required',
                'int',
                'exists:products,id'
            ],
            'user_id'    =>  [
                'required',
                'int',
                'exists:users,id'
            ],
        ];
    }
}
