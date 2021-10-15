<?php

namespace App\Http\Resources\Gateway;

use App\Http\Resources\Currency\CurrencyCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class GatewayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "code" => $this->code,
            "status" => $this->status,
            "currencies" => new CurrencyCollection(
                $this->whenLoaded("currencies")
            ),
        ];
    }
}
