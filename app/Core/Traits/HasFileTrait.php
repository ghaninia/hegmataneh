<?php

namespace App\Core\Traits;

use App\Models\File;

trait HasFileTrait
{
    public function files()
    {
        return $this->morphToMany(File::class, "fileable")->withPivot(["usage"]);
    }
}
