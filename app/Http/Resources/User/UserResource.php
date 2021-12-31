<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Currency\CurrencyResource;
use App\Http\Resources\Role\RoleResource;
use App\Http\Resources\File\FileCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => $this->id,
            "is_trashed" => $this->trashed(),
            'name' => $this->name,
            'status' => $this->status,
            'email' => $this->email,
            'mobile' => $this->mobile,
            "username" => $this->username,
            "bio" => $this->bio,
            "created_at" => $this->created_at,
            "role"  => new RoleResource($this->whenLoaded("role")),
            "currency" => new CurrencyResource($this->whenLoaded("currency")),
            "language" => new CurrencyResource($this->whenLoaded("language")),
            "files" => new FileCollection($this->whenLoaded("files"))
        ];
    }
}
