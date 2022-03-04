<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Employees;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeResource;

class StoreController extends Controller
{
    public function __invoke(EmployeeRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['image'] = $request->file('image')->storeAs(
            path:    'employees',
            name:    time() .'.' . $request->file('image')->getClientOriginalExtension(),
            options: ['disk' => 'public']
        );

        $data['password'] = Hash::make($data['password']);

        $data['type'] = 'employee';
        $user = User::query()->create($data);

        return new JsonResponse(
            data: new EmployeeResource(
                resource: $user
            ),
            status: Response::HTTP_CREATED
        );
    }
}
