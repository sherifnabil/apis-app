<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Categories;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;

class IndexController extends Controller
{
    public function __invoke(Request $request): JsonResponse|Response
    {
        $categories = Category::query()
        ->with(['products'])
        ->when($request->has('active'), function ($query) use ($request) {
            if (in_array($request->active, [0, 1])) {
                $query->where('active', !!$request->active);
            }
        })->get();

        return new JsonResponse(
            data: CategoryResource::collection(
                resource: $categories
            ),
            status: Response::HTTP_ACCEPTED
        );
    }
}
