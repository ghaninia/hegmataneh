<?php

namespace App\Kernel\Filemanager\Traits;

use App\Models\File;

trait HasFileableTrait
{

    public function files()
    {
        return $this->morphMany(File::class, "fileable");
    }

}
