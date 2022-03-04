<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class ProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row): ?Model
    {
        return new Product([
            'name'  => $row['name'],
            'price'  => $row['price'],
            'category_id'  => $row['category'],
        ]);
    }


    public function rules(): array
    {
        return [
            '0' => 'required|string',   //  name
            '1' => 'required|numeric',  // price
            '2' => 'required|exists:categories,id',  // category_id
        ];
    }
}
