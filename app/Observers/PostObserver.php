<?php

namespace App\Observers;

use App\Models\Post;
use App\Kernel\Enums\EnumsPost;
use App\Services\Post\PostService;

class PostObserver
{
    public function created(Post $post)
    {
        if ($post->status == EnumsPost::STATUS_SCHEDULE) {
            app(PostService::class)->setPublishedJob($post);
        }
    }

    public function updated(Post $post)
    {
        if ($post->status == EnumsPost::STATUS_SCHEDULE) {
            app(PostService::class)->setPublishedJob($post);
        }
    }

    public function forceDelete(Post $post)
    {
        $post->terms()->detach();
        $post->files()->detach();
        $post->serials()->detach();
        $post->skills()->detach();
        $post->views()->detach();
        $post->votes()->detach();
        $post->comments()->delete();
        $post->orders()->delete();
        $post->prices()->delete();
        $post->productInformation()->delete();
        $post->slugs()->delete();
        $post->translations()->delete();
    }
}
