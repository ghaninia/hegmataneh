<?php

namespace App\Kernel\Enums;

use App\Kernel\Enums\Abstracts\Enum;

class EnumsPost extends Enum
{
    const TYPE_POST = "post";
    const TYPE_PRODUCT = "product";
    const TYPE_PAGE = "page";

    const STATUS_PUBLISHED = "published";
    const STATUS_DISABLED = "disabled";
    const STATUS_DRAFT = "draft";
    const STATUS_SCHEDULE = "schedule";

    const FORMAT_CONTEXT = "context";
    const FORMAT_PODCAST = "podcast";
    const FORMAT_VIDEO = "video";

    const FIELD_CONTENT = "content";
    const FIELD_FAQ = "faq";
    const FIELD_GOAL_POST = "goal_post";
    const FIELD_EXCERPT = "excerpt";
    const FIELD_TITLE = "title";
}
