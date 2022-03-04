<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Employees;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\File;

class DeleteController extends Controller
{
    public function __invoke(Request $request, $id): Response
    {
        $employee = User::query()->find($id);

        if (! $employee) {
            return new Response(
                content: 'Not Found Entity',
                status: Response::HTTP_NOT_FOUND
            );
        }

        if (File::exists($employee->image)) {
            File::unlink($employee->image);
        }

        $employee->delete();

        return new Response(
            content: null,
            status: Response::HTTP_ACCEPTED
        );
    }
}
