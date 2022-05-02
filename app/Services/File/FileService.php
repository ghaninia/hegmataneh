<?php

namespace App\Services\File;

use App\Kernel\Filemanager\Interfaces\FileInterface;
use App\Models\File;

class FileService implements FileServiceInterface
{
    /**
     * find file or folder
     * @param string $uuid
     * @param string|null $type
     * @return FileInterface|null
     */
    public function find(string $uuid , string $type = null ) : ?FileInterface
    {
        return File::query()
            ->when($type , fn($query) => $query->where("type" , $type))
            ->find($uuid);
    }

    /**
     * create new file
     * @param array $data
     * @return FileInterface
     */
    public function create(array $data = []) : FileInterface
    {
        return File::create([
            "user_id" => $data["user_id"] ?? null ,
            "folder_id" => $data["folder_id"] ?? null ,
            "type" => $data["type"] ?? null ,
            "driver" => $data["driver"] ,
            "name" => $data["name"] ,
            "path" => $data["path"] ,
            "extension" => $data["extension"] ?? null ,
            "mime_type" => $data["mime_type"] ?? null ,
            "size" => $data["size"] ?? null ,
            "created_at" => now() ,
        ]);
    }
}
