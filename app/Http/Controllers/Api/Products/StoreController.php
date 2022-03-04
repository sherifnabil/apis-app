<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Products;

use App\Models\Product;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Requests\Api\ProductRequest;

class StoreController extends Controller
{
    public function __invoke(ProductRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['image'] = $request->file('image')->storeAs(
            path:    'products',
            name:    time() .'.' . $request->file('image')->getClientOriginalExtension(),
            options: ['disk' => 'public']
        );

        $category = Product::query()->create($data);

        return new JsonResponse(
            data: new ProductResource(
                resource: $category->load('category')
            ),
            status: Response::HTTP_CREATED
        );
    }
}
