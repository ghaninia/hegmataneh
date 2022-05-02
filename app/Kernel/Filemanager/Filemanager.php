<?php

namespace App\Kernel\Filemanager;

use App\Kernel\Filemanager\Interfaces\FileInterface;
use Illuminate\Support\Facades\Storage;

class Filemanager
{

    /**
     * get link
     * @param FileInterface $file
     * @return string
     */
    public function link(FileInterface $file)
    {
        return Storage::disk($file->disk)->url($file->path);
    }

}
