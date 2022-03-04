<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserAuthDataResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'  =>  $this[0]->id,
            'type'=>  'user',
            'attributes' =>  [
                'name'  =>  $this[0]->name,
                'email' =>  $this[0]->email,
            ],
            'token' =>  $this[1]['token']
        ];
    }
}
