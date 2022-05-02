<?php

namespace App\Http\Resources\File;

use App\Kernel\Enums\EnumsFile;
use App\Http\Resources\User\UserResource;
use App\Kernel\Filemanager\Filemanager;
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
            "driver" => $this->driver ,
            "link" => (new Filemanager())->link($this->resource),
            "user" => new UserResource( $this->whenLoaded("user") ) ,
            "folder" => new FileResource( $this->whenLoaded("folder") ) ,
            "type" => $this->type ,
            "name" => $this->name ,
            "path" => $this->path ,
            "created_at" => $this->created_at ,
            "updated_at" => $this->updated_at ,
        ] + match ($this->type) {
            EnumsFile::TYPE_FILE => [
                "extension" => $this->extension ,
                "mime_type" => $this->mime_type ,
                "size" => $this->size ,
            ] ,
            default => [
                "childrens" => new FileCollection( $this->whenLoaded("childrens") ) ,
            ]
        };
    }
}
