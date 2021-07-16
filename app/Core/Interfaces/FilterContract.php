<?php

namespace App\Core\Interfaces;

interface FilterContract
{
    public function handle($value): void;
}
