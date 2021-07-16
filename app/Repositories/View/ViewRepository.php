<?php

namespace App\Repositories\View;

use App\Models\View;
use App\Repositories\View\ViewRepositoryInterface;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;

class ViewRepository extends BaseRepository implements ViewRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return View::class;
    }
}
