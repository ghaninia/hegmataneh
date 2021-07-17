<?php

namespace App\Services\Page;

use App\Core\Enums\EnumsPost;
use App\Repositories\Post\PostRepository;
use App\Services\Page\PageServiceInterface;

class PageService implements PageServiceInterface
{
    protected $postRepo;
    public function __construct(PostRepository $postRepo)
    {
        $this->postRepo = $postRepo;
    }


    /**
     * لیست تمام برگه ها
     * @param array $filters
     * @return Paginator
     */
    public function list(array $filters)
    {
        return
            $this->postRepo->query()
            ->where("type", EnumsPost::TYPE_PAGE)
            ->filterBy($filters)
            ->paginate();
    }
}
