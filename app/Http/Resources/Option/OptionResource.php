<?php

namespace App\Http\Resources\Option;

use Illuminate\Http\Resources\Json\JsonResource;

class OptionResource extends JsonResource
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
            "key" => $this->key ,
            "type" => $this->type ,
            "value" => $this->value ,
            "default" => $this->default
        ];
    }
}
