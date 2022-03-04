<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Products;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class DeleteController extends Controller
{
    public function __invoke(Request $request, $id): Response
    {
        $product = Product::query()->find($id);

        if (! $product) {
            return new Response(
                content: 'Not Found Entity',
                status: Response::HTTP_NOT_FOUND
            );
        }

        if (File::exists($product->image)) {
            File::unlink($product->image);
        }

        $product->delete();

        return new Response(
            content: null,
            status: Response::HTTP_ACCEPTED
        );
    }
}
