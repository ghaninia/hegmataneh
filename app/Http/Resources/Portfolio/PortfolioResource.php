<?php

namespace App\Http\Resources\Portfolio;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PortfolioResource extends JsonResource
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
            "id" => $this->id ,
            "name" => $this->name ,
            "description" => $this->description ,
            "demo" => $this->demo ,
            "excerpt" => $this->excerpt ,
            "percent" => $this->percent ,
            "launched_at" => $this->launched_at ,
            "created_at" => $this->created_at ,
            "user" => new UserResource( $this->whenLoaded("user"))
        ];
    }
}
