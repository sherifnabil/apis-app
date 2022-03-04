<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Clients;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\ClientResource;

class StoreController extends Controller
{
    public function __invoke(ClientRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['image'] = $request->file('image')->storeAs(
            path:    'clients',
            name:    time() .'.' . $request->file('image')->getClientOriginalExtension(),
            options: ['disk' => 'public']
        );

        $data['password'] = Hash::make($data['password']);

        $data['type'] = 'client';
        $user = User::query()->create($data);

        return new JsonResponse(
            data: new ClientResource(
                resource: $user
            ),
            status: Response::HTTP_CREATED
        );
    }
}
