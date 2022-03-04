<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Clients;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\File;

class DeleteController extends Controller
{
    public function __invoke(Request $request, $id): Response
    {
        $client = User::query()->find($id);

        if (! $client) {
            return new Response(
                content: 'Not Found Entity',
                status: Response::HTTP_NOT_FOUND
            );
        }

        if (File::exists($client->image)) {
            File::unlink($client->image);
        }

        $client->delete();

        return new Response(
            content: null,
            status: Response::HTTP_ACCEPTED
        );
    }
}
