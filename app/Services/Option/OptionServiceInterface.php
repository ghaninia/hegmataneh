<?php

namespace App\Services\Option;

use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;

interface OptionServiceInterface
{
    public static function getInstance() : self;
    public function service() : BaseRepository;
    public function getRecordesInDatabase(): array ;
}
