<?php

namespace App\Services\Portfolio;

use Illuminate\Contracts\Pagination\Paginator;
use App\Repositories\Portfolio\PortfolioRepository;
use App\Services\Portfolio\PortfolioServiceInterface;

class PortfolioService implements PortfolioServiceInterface
{
    protected $portfolioRepo;
    public function __construct(PortfolioRepository $portfolioRepo)
    {
        $this->portfolioRepo = $portfolioRepo;
    }

    /**
     * لیست تمام نمونه کار ها
     * @param array $filters
     * @return Paginator
     */
    public function list(array $filters): Paginator
    {
        return
            $this->portfolioRepo->query()
            ->filterBy($filters)
            ->paginate();
    }
}
