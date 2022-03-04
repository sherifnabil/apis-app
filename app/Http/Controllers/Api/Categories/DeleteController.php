<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Categories;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class DeleteController extends Controller
{
    public function __invoke(Request $request, $id): Response
    {
        $category = Category::query()->find($id);

        if (! $category) {
            return new Response(
                content: 'Not Found Entity',
                status: Response::HTTP_NOT_FOUND
            );
        }

        if (File::exists($category->image)) {
            File::unlink($category->image);
        }

        $category->delete();

        return new Response(
            content: null,
            status: Response::HTTP_ACCEPTED
        );
    }
}
