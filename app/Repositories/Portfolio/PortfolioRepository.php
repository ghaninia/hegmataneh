<?php

namespace App\Repositories\Portfolio;

use App\Models\Portfolio;
use App\Repositories\Portfolio\PortfolioRepositoryInterface;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;

class PortfolioRepository extends BaseRepository implements PortfolioRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Portfolio::class ;
    }

    public function query()
    {
        return $this->model ;
    }
}
