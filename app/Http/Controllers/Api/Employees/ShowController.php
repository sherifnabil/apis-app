<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Employees;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeResource;
use App\Models\User;

class ShowController extends Controller
{
    public function __invoke(Request $request, int $id): JsonResponse|Response
    {
        $employee = User::query()->find($id);

        if (! $employee) {
            return new Response(
                content: 'Not Found Entity',
                status: Response::HTTP_NOT_FOUND
            );
        }

        return new JsonResponse(
            data: new EmployeeResource(
                resource: $employee
            ),
            status: Response::HTTP_ACCEPTED
        );
    }
}
