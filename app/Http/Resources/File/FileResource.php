<?php

namespace App\Http\Resources\File;

use App\Core\Enums\EnumsFile;
use App\Http\Resources\User\UserResource;
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


        $hasRecursive = $request->has_recursive && ($this->type === EnumsFile::TYPE_FOLDER);

        return [
            "id" => $this->id,

            "parent" => new FileCollection($this->whenLoaded("parent")),

            $this->mergeWhen($hasRecursive, [
                "childrens" => new FileCollection($this->whenLoaded("childrens"))
            ]),

            $this->mergeWhen(isset($this->fileables_count), [
                "fileables_count" => $this->fileables_count,
            ]),

            "user" => new UserResource($this->whenLoaded("user")),
            "type" => $type = $this->type,
            "name" => $this->name,
            "extension" => $this->extension,
            "mime_type" => $this->mime_type,
            "size" => $this->size,

            "path" => $this->when($type == EnumsFile::TYPE_FILE, function () {
                return
                    app(FileService::class)
                    ->setUser($this->user_id)
                    ->link($this->id, $this->extension);
            }),

            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
