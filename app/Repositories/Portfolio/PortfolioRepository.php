<?php

namespace App\Repositories\Portfolio;

use App\Models\Portfolio;
use App\Core\Traits\ExteraQueriesTrait;
use App\Repositories\Portfolio\PortfolioRepositoryInterface;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;

class PortfolioRepository extends BaseRepository implements PortfolioRepositoryInterface
{

    use ExteraQueriesTrait ;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Portfolio::class ;
    }
}
