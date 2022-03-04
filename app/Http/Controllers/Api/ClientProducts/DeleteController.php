<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\ClientProducts;

use Illuminate\Http\Request;
use App\Models\ClientProduct;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class DeleteController extends Controller
{
    public function __invoke(Request $request, $id): Response
    {
        $clientProduct = ClientProduct::query()->find($id);

        if (! $clientProduct) {
            return new Response(
                content: 'Not Found Entity',
                status: Response::HTTP_NOT_FOUND
            );
        }

        $clientProduct->delete();

        return new Response(
            content: null,
            status: Response::HTTP_ACCEPTED
        );
    }
}
