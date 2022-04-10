<?php

namespace App\Kernel\Basket\Interfaces;

use App\Kernel\Model\Interfaces\ModelableInterface;

interface BasktableInterface extends ModelableInterface
{
    public function baskets() ;
    public function prices() ;
}
