<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'    =>  $this->id,
            'type'  =>  'client-product',
            'attributes'    =>  [
                'product_id'  =>  $this->product_id,
                'user_id'  =>  $this->user_id,
            ],
            'relationships' =>  [
                'product'  =>  new ProductResource(
                    resource: $this->whenLoaded(
                        relationship: 'product'
                    )
                ),
                'user'  =>  new ClientResource(
                    resource: $this->whenLoaded(
                        relationship: 'user'
                    )
                )
            ]
        ];
    }
}
