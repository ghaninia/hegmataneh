<?php

namespace App\Kernel\DatabaseFilter\Interfaces;

/**
 * @property public slugable
 */
interface FilterInterface
{
    public function handle($value): void;
}
