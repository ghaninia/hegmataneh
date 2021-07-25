<?php

namespace App\Core\Interfaces;

interface FilterInterface
{
    public function handle($value): void;
}
