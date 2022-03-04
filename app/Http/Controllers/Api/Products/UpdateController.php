<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Products;

use App\Models\Product;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Requests\Api\ProductRequest;

class UpdateController extends Controller
{
    public function __invoke(ProductRequest $request, $id)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->storeAs(
                path: 'products',
                name: time() .'.' . $request->file('image')->getClientOriginalExtension(),
                options: ['disk' => 'public']
            );
        }

        $product = Product::query()->with(['category'])->find($id);

        if (! $product) {
            return new Response(
                content: 'Not Found Entity',
                status: Response::HTTP_NOT_FOUND
            );
        }

        $product->update($data);

        return new JsonResponse(
            data: new ProductResource(
                resource: $product
            ),
            status: Response::HTTP_ACCEPTED
        );
    }
}
