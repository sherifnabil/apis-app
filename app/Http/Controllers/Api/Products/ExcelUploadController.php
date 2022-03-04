<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Products;

use Illuminate\Http\Response;
use App\Imports\ProductsImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\UploadProductsRequest;

class ExcelUploadController extends Controller
{
    public function __invoke(UploadProductsRequest $request): Response
    {
        Excel::import(new ProductsImport, $request->file('file'));

        return new Response(
            content: null,
            status: Response::HTTP_ACCEPTED
        );
    }
}
