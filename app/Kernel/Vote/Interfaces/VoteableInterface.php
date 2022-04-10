<?php

namespace App\Kernel\Vote\Interfaces;

use App\Kernel\Model\Interfaces\ModelableInterface;

interface VoteableInterface extends ModelableInterface
{
    public function votes();
}
