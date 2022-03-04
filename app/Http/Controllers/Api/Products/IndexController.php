<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Products;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class IndexController extends Controller
{
    public function __invoke(Request $request): JsonResponse|Response
    {
        $categories = Product::query()
        ->with(['category'])
        ->when($request->has('active'), function ($query) use ($request) {
            if (in_array($request->active, [0, 1])) {
                $query->where('active', !!$request->active);
            }
        })
        ->when($request->has('price') && $request->has('operator') && $request->operator === 'more', function ($query) use ($request) {
            $query->where('price', '>', $request->price);
        })
        ->when($request->has('price') && $request->has('operator') && $request->operator === 'less', function ($query) use ($request) {
            $query->where('price', '<', $request->price);
        })
        ->get();

        return new JsonResponse(
            data: ProductResource::collection(
                resource: $categories
            ),
            status: Response::HTTP_ACCEPTED
        );
    }
}
