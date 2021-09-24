<?php

namespace App\Services\Price;

use Illuminate\Database\Eloquent\Model;

interface PriceServiceInterface
{
    public function create(Model $model, array $currencies) : void ;
}
