<?php

namespace App\Repositories\Translation;

use App\Models\Translation;
use App\Core\Traits\ExteraQueriesTrait;
use App\Repositories\Translation\TranslationRepositoryInterface;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;

class TranslationRepository extends BaseRepository implements TranslationRepositoryInterface
{
    use ExteraQueriesTrait; 
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Translation::class ;
    }
}
