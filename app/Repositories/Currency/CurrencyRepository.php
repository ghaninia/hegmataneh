<?php

namespace App\Repositories\Currency;

use App\Models\Currency;
use App\Core\Traits\ExteraQueriesTrait;
use App\Repositories\Currency\CurrencyRepositoryInterface;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;

class CurrencyRepository extends BaseRepository implements CurrencyRepositoryInterface
{
    use ExteraQueriesTrait ;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Currency::class ;
    }
}
