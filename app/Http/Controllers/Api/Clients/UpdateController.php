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

class UpdateController extends Controller
{
    public function __invoke(ClientRequest $request, int $id)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->storeAs(
                path: 'clients',
                name: time() .'.' . $request->file('image')->getClientOriginalExtension(),
                options: ['disk' => 'public']
            );
        }

        if (isset($data['type'])) {
            unset($data['type']);
        }

        $employee = User::query()->find($id);

        if (! $employee) {
            return new Response(
                content: 'Not Found Entity',
                status: Response::HTTP_NOT_FOUND
            );
        }

        if ($request->get('password')) {
            $data['password'] = Hash::make($data['password']);
        }

        unset($data['email']);
        $employee->update($data);

        return new JsonResponse(
            data: new ClientResource(
                resource: $employee
            ),
            status: Response::HTTP_ACCEPTED
        );
    }
}
