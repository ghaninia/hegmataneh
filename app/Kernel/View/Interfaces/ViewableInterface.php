<?php

namespace App\Kernel\View\Interfaces;

use App\Kernel\Model\Interfaces\ModelableInterface;

interface ViewableInterface extends ModelableInterface
{
    public function views();
}
