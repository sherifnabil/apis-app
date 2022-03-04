<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Categories;

use App\Models\Category;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\Api\CategoryRequest;

class UpdateController extends Controller
{
    public function __invoke(CategoryRequest $request, int $id)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->storeAs(
                path: 'categories',
                name: time() .'.' . $request->file('image')->getClientOriginalExtension(),
                options: ['disk' => 'public']
            );
        }

        $category = Category::query()->with(['products'])->find($id);

        if (! $category) {
            return new Response(
                content: 'Not Found Entity',
                status: Response::HTTP_NOT_FOUND
            );
        }

        $category->update($data);

        return new JsonResponse(
            data: new CategoryResource(
                resource: $category
            ),
            status: Response::HTTP_ACCEPTED
        );
    }
}
