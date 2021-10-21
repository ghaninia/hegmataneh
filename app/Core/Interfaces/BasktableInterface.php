<?php

namespace App\Core\Interfaces;

interface BasktableInterface extends ModelableInterface 
{
    public function baskets() ;
    public function prices() ;
}
