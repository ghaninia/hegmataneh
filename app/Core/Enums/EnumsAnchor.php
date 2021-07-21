<?php

namespace App\Core\Enums;

use App\Models\Post;
use App\Models\Comment;
use App\Core\Abstracts\Enum;

class EnumsAnchor extends Enum
{
    const TYPE_POST = Post::class;
    const TYPE_COMMENT  = Comment::class;
}
