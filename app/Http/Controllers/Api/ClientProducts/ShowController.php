<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\ClientProducts;

use Illuminate\Http\Request;
use App\Models\ClientProduct;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClientProductResource;

class ShowController extends Controller
{
    public function __invoke(Request $request, int $id): JsonResponse|Response
    {
        $clientProduct = ClientProduct::query()->find($id);

        if (! $clientProduct) {
            return new Response(
                content: 'Not Found Entity',
                status: Response::HTTP_NOT_FOUND
            );
        }

        return new JsonResponse(
            data: new ClientProductResource(
                resource: $clientProduct->load(['product', 'user'])
            ),
            status: Response::HTTP_CREATED
        );
    }
}
