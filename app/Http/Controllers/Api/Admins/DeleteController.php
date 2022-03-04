<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admins;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\File;

class DeleteController extends Controller
{
    public function __invoke(Request $request, $id): Response
    {
        $admin = User::query()->find($id);

        if (! $admin) {
            return new Response(
                content: 'Not Found Entity',
                status: Response::HTTP_NOT_FOUND
            );
        }

        if (File::exists($admin->image)) {
            File::unlink($admin->image);
        }

        $admin->delete();

        return new Response(
            content: null,
            status: Response::HTTP_ACCEPTED
        );
    }
}
