<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Employees;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\User;

class UpdateController extends Controller
{
    public function __invoke(EmployeeRequest $request, int $id)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->storeAs(
                path: 'employees',
                name: time() .'.' . $request->file('image')->getClientOriginalExtension(),
                options: ['disk' => 'public']
            );
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

        if (isset($data['type'])) {
            unset($data['type']);
        }

        unset($data['email']);
        $employee->update($data);

        return new JsonResponse(
            data: new EmployeeResource(
                resource: $employee
            ),
            status: Response::HTTP_ACCEPTED
        );
    }
}
