<?php

namespace App\Repositories\Basket;

use App\Core\Traits\ExteraQueriesTrait;
use App\Models\Basket;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;
use App\Repositories\Basket\BasketRepositoryInterface;

class BasketRepository extends BaseRepository implements BasketRepositoryInterface
{
    use ExteraQueriesTrait ;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Basket::class ;
    }
}
