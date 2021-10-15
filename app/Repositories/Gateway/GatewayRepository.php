<?php

namespace App\Repositories\Gateway;

use App\Models\Gateway;
use App\Core\Traits\ExteraQueriesTrait;
use App\Repositories\Gateway\GatewayRepositoryInterface;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;

class GatewayRepository extends BaseRepository implements GatewayRepositoryInterface
{
    use ExteraQueriesTrait; 
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Gateway::class;
    }
}
