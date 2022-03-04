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

class UpdateController extends Controller
{
    public function __invoke(AdminRequest $request, int $id)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->storeAs(
                path: 'admins',
                name: time() .'.' . $request->file('image')->getClientOriginalExtension(),
                options: ['disk' => 'public']
            );
        }

        if ($request->get('password')) {
            $data['password'] = Hash::make($data['password']);
        }

        $admin = User::query()->find($id);

        if (! $admin) {
            return new Response(
                content: 'Not Found Entity',
                status: Response::HTTP_NOT_FOUND
            );
        }

        $admin->update($data);

        return new JsonResponse(
            data: new AdminResource(
                resource: $admin
            ),
            status: Response::HTTP_ACCEPTED
        );
    }
}
