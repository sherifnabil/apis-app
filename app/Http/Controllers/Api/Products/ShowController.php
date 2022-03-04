<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Products;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ShowController extends Controller
{
    public function __invoke(Request $request, int $id): JsonResponse|Response
    {
        $product = Product::query()->with('category')->find($id);

        if (! $product) {
            return new Response(
                content: 'Not Found Entity',
                status: Response::HTTP_NOT_FOUND
            );
        }

        return new JsonResponse(
            data: new ProductResource(
                resource: $product
            ),
            status: Response::HTTP_ACCEPTED
        );
    }
}
