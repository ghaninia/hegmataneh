<?php

namespace App\Services\Page;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
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

    /**
     * ساخت برگه جدید
     * @param array $data
     * @return Post
     */
    public function create(User $user, array $data): Post
    {
        return
            $this->postRepo->create([
                "type" => EnumsPost::TYPE_PAGE,
                "status" => $data["status"],
                "user_id" => $user->id,
                "comment_status" => $data["comment_status"] ?? false,
                "vote_status" => $data["vote_status"] ?? false,
                "format" => $data["format"] ?? EnumsPost::FORMAT_CONTEXT,
                "development" => $data["development"] ?? 0,
                "title" => $data["title"],
                "goal_post" => $data["goal_post"] ?? NULL,
                "slug" => slug($data["slug"] ?? NULL, $data["title"]),
                "content" => $data["content"] ?? NULL,
                "faq" => $data["faq"] ?? NULL,
                "excerpt" => $data["excerpt"] ?? NULL ,
                "theme" => $data["theme"] ?? NULL,
                "published_at" => $data["published_at"] ?? NULL,
                "created_at" => $data["created_at"] ?? Carbon::now()
            ]);
    }
}
