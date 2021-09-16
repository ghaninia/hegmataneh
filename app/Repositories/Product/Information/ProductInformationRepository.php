<?php

namespace App\Repositories\Product\Information;

use App\Models\ProductInformation;
use App\Core\Traits\ExteraQueriesTrait;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;
use App\Repositories\Product\Information\ProductInformationRepositoryInterface;

class ProductInformationRepository extends BaseRepository implements ProductInformationRepositoryInterface
{
    use ExteraQueriesTrait ;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProductInformation::class ;
    }
}
