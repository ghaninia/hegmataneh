<?php

namespace App\Repositories\Language;

use App\Models\Language;
use App\Core\Traits\ExteraQueriesTrait;
use App\Repositories\Language\LanguageRepositoryInterface;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;

class LanguageRepository extends BaseRepository implements LanguageRepositoryInterface
{
    use ExteraQueriesTrait ;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Language::class ;
    }
}
