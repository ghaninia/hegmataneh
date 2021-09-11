<?php

namespace App\Repositories\Price;

use App\Models\Price;
use App\Core\Traits\ExteraQueriesTrait;
use App\Repositories\Price\PriceRepositoryInterface;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;

class PriceRepository extends BaseRepository implements PriceRepositoryInterface
{
    use ExteraQueriesTrait ;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Price::class ;
    }
}
