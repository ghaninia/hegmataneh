<?php

namespace App\Services\Filemanager;

interface FilemanagerServiceInterface
{
    public function list(array $filters, int $currentPage = 0) ;
}
