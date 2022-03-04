<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\ClientProducts;

use App\Models\User;
use App\Models\ClientProduct;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientProductsRequest;
use App\Http\Resources\ClientProductResource;

class UpdateController extends Controller
{
    public function __invoke(ClientProductsRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = User::query()->find($data['user_id']);

        $user->products()->attach($data['product_id']);

        if (! $user) {
            return new Response(
                content: 'Not Found Entity',
                status: Response::HTTP_NOT_FOUND
            );
        }

        $clientProduct = ClientProduct::query()->where('user_id', $user->id)
        ->where('product_id', $data['product_id'])
        ->first();

        return new JsonResponse(
            data: new ClientProductResource(
                resource: $clientProduct->load(['product', 'user'])
            ),
            status: Response::HTTP_CREATED
        );
    }
}
