<?php

namespace App\Services\Option;

interface OptionServiceInterface
{
    public static function getInstance(): self;
    public function getRecordesInDatabase(): array;
}
