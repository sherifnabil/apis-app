<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admins;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\AdminRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\AdminResource;

class StoreController extends Controller
{
    public function __invoke(AdminRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['image'] = $request->file('image')->storeAs(
            path:    'admins',
            name:    time() .'.' . $request->file('image')->getClientOriginalExtension(),
            options: ['disk' => 'public']
        );

        $data['type'] = 'employee';
        $data['password'] = Hash::make($data['password']);

        $user = User::query()->create($data);

        return new JsonResponse(
            data: new AdminResource(
                resource: $user
            ),
            status: Response::HTTP_CREATED
        );
    }
}
