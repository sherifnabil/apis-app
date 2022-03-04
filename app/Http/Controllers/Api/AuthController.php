<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserAuthDataResource;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $request['password'] = Hash::make($request['password']);
        $request['remember_token'] = Str::random(60);

        $user = User::create($request->toArray());

        $response = ['token' => $user->createToken('some token')->accessToken];

        return new JsonResponse(
            data: new UserAuthDataResource(
                resource: [$user, $response]
            ),
            status: Response::HTTP_OK
        );
    }

    public function accessToken(UserRequest $request): Response|JsonResponse
    {
        if (! $user = User::where('email', $request->email)->first()) {
            return new Response(
                content: ["message" =>'User does not exist'],
                status: Response::HTTP_NOT_FOUND
            );
        }

        if (! Hash::check($request->password, $user->password)) {
            return new Response(
                content: ["message" =>'Password mismatch'],
                status: Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        if (in_array($user->type, ['employee', 'client']) && $user->active == 0) {
            return new Response(
                content: ["message" =>'Account is Deactivated!'],
                status: Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $response = ['token' => $user->createToken('some token')->accessToken];

        return new JsonResponse(
            data: new UserAuthDataResource(
                resource: [$user, $response]
            ),
            status: Response::HTTP_OK
        );
    }

    public function logout(Request $request): Response
    {
        $token = $request->user()->token();
        $token->revoke();

        return new Response(
            content: [
                'message' => 'You have been successfully logged out!'
            ],
            status: Response::HTTP_OK
        );
    }
}
