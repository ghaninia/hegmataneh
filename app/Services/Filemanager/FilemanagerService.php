<?php

namespace App\Services\Filemanager;

use App\Models\File;
use App\Kernel\Lazyloading\Lazyloading;

class FilemanagerService implements FilemanagerServiceInterface
{
    /**
     * Get a list of folders and files
     * @param array $filters
     * @param int $currentPage
     * @return array
     */
    public function list(array $filters, int $currentPage = 0)
    {
        $query = File::query()->filterBy($filters);
        return (new Lazyloading)->query($query)->make($currentPage) ;
    }
}
