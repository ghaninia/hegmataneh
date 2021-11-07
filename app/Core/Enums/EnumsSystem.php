<?php

namespace App\Core\Enums;

use App\Models\Post;
use App\Models\Comment;
use App\Core\Abstracts\Enum;

class EnumsSystem extends Enum
{
    const TYPE_POST = Post::class;
    const TYPE_COMMENT  = Comment::class;
    const WALLCARD_USER = "user";
    const WALLCARD_GATEWAY = "gateway";
    const WALLCARD_FILE = "file";
    const WALLCARD_FOLDER = "folder";

    const ORDER_ASC = "asc";
    const ORDER_DESC = "desc";
}
