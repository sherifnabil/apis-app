<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admins;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdminResource;
use App\Models\User;

class ShowController extends Controller
{
    public function __invoke(Request $request, int $id): JsonResponse|Response
    {
        $admin = User::query()->find($id);

        if (! $admin) {
            return new Response(
                content: 'Not Found Entity',
                status: Response::HTTP_NOT_FOUND
            );
        }

        return new JsonResponse(
            data: new AdminResource(
                resource: $admin
            ),
            status: Response::HTTP_ACCEPTED
        );
    }
}
