<?php

namespace App\Core\Interfaces;

interface VoteableInterface extends ModelableInterface
{
    public function votes();
}
