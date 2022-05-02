<?php

namespace App\Kernel\Lazyloading;

use Illuminate\Database\Eloquent\Builder;

class Lazyloading
{
    /**
     * @var Builder
     */
    private Builder $query;

    /**
     * @param int $perPage
     */
    public function __construct(
        public int $perPage = 50
    ) {
    }

    /**
     * set query
     * @param Builder $query
     * @return $this
     */
    public function query(Builder $query)
    {
        $this->query = $query;
        return $this;
    }

    /**
     * create lazy loading list
     * @param $currentPage
     * @return array
     */
    public function make($currentPage)
    {
        $total = (clone $this->query)->count();

        $lastPage = ceil($total / $this->perPage);
        $lastPage = $lastPage ? --$lastPage : $lastPage;

        $result =
            (clone $this->query)
            ->skip($currentPage * $this->perPage)
            ->take($this->perPage)
            ->get();

        return [
            $result,
            $total ,
            $lastPage,
            $currentPage,
            $nextPage = $lastPage == 0 || $currentPage >= $this->perPage ? null : ++$currentPage
        ];
    }
}
