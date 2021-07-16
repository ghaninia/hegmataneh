<?php

namespace App\Services\View;

use App\Repositories\View\ViewRepository;
use App\Services\View\ViewServiceInterface;

class ViewService implements ViewServiceInterface
{
    protected $viewRepo;

    public function __construct(ViewRepository $viewRepo)
    {
        $this->viewRepo = $viewRepo;
    }

    public function list(array $filters)
    {
        return
            $this->viewRepo->query()
            ->filterBy($filters)
            ->paginate();
    }
}
