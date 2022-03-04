<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Categories;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class BasedProductController extends Controller
{
    public function __invoke(Request $request): JsonResponse|Response
    {
        $categories = Category::with(['products' => function ($query) use ($request) {
            $query
            ->when($request->has('operator') && $request->operator == 'less', function ($query) use ($request) {
                $query->where('price', '<', $request->price);
            })
            ->when($request->has('operator') && $request->operator == 'more', function ($query) use ($request) {
                $query->where('price', '>', $request->price);
            })
            ->when($request->has('active') && $request->active == 1, function ($query) use ($request) {
                $query->where('active', true);
            });
        }])

        ->when($request->has('active') && $request->active == 1, function ($query) use ($request) {
            $query->where('active', true);
        })

        ->when($request->has('operator') && $request->operator == 'more', function ($query) use ($request) {
            $query->whereHas('products', function ($q) use ($request) {
                $q->where(function ($builder) use ($request) {
                    $builder->where('price', '>', $request->price);
                });
            });
        })
        ->when($request->has('operator') && $request->operator == 'less', function ($query) use ($request) {
            $query->whereHas('products', function ($q) use ($request) {
                $q->where('price', '<', $request->price);
            });
        })
        ->when($request->has('product') && $request->product == 'empty', function ($query) use ($request) {
            $query->doesntHave('products');
        })
        ->when($request->has('active') && $request->active == 1, function ($query) use ($request) {
            $query->whereHas('products', function ($q) {
                $q->where('active', true);
            });
        })
        ->get();

        return new JsonResponse(
            data: CategoryResource::collection(
                resource: $categories
            ),
            status: Response::HTTP_ACCEPTED
        );
    }
}
