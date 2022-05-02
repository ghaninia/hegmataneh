<?php

namespace App\Http\Resources\File;

use App\Kernel\Enums\EnumsFile;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
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
            "id" => $this->id ,
            "user" => new UserResource( $this->whenLoaded("user") ) ,
            "type" => $this->type ,
            "name" => $this->name ,
            "relpath" => $this->relpath ,
            "created_at" => $this->created_at ,
            "updated_at" => $this->updated_at ,
        ] + match ($this->type) {
            EnumsFile::TYPE_FILE => [
                "extension" => $this->extension ,
                "mime_type" => $this->mime_type ,
                "size" => $this->size ,
            ] ,
            default => []
        };
    }
}
