<?php

namespace App\Core\Interfaces;

/**
 * @property public slugable
 */
interface FilterInterface
{
    public function handle($value): void;
}
