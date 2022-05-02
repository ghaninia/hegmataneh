<?php

namespace App\Services\Filemanager;

use App\Kernel\Filemanager\Interfaces\FileInterface;
use App\Models\User;

interface FilemanagerServiceInterface
{
    public function list(array $filters, int $currentPage = 0) ;
    public function uploads( array $attachments = [] , FileInterface $folder = null , User $user = null );
}
