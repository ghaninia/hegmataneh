<?php

namespace App\Http\Resources\File\Guest;

use App\Services\File\FileService;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
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
            "path" =>  app(FileService::class)
                ->setUser($this->user_id)
                ->link($this->id, $this->extension)
        ];
    }
}
