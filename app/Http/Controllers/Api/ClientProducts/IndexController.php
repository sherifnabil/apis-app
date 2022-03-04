<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\ClientProducts;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClientProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id'    =>  [
                'required',
                'int',
                'exists:users,id'
            ]
        ]);

        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $data = $request->all();


        $user = User::query()->find($data['user_id']);

        return new JsonResponse(
            data: new ClientProducts(
                resource: $user->load(['products'])
            ),
            status: Response::HTTP_CREATED
        );
    }
}
