<?php

namespace App\Http\Resources\Currency;

use App\Http\Resources\Gateway\GatewayResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "code" => $this->code,
            "name" => $this->name,
            "gateways" => new GatewayResource($this->whenLoaded("gateways"))
        ];
    }
}
