<?php

namespace App\Kernel\Enums;

use App\Kernel\Enums\Abstracts\Enum;

class EnumsRole extends Enum
{
    const PERMISSION_QUOTATION = "quotation";
    const PERMISSION_ROLE = "role";
    const PERMISSION_OPTION = "option";
    const PERMISSION_MENU = "menu";
    const PERMISSION_SLIDER = "slider";
    const PERMISSION_USER = "user";
    const PERMISSION_PRODUCT_SELF = "product.self";
    const PERMISSION_PRODUCT = "product";
    const PERMISSION_POST = "post";
    const PERMISSION_POST_SELF = "post.self";
    const PERMISSION_PAGE = "page";
    const PERMISSION_PAGE_SELF = "page.self";
    const PERMISSION_CATEGORY = "category";
    const PERMISSION_TAG = "tag";
    const PERMISSION_FILEMANAGER = "filemanager";
    const PERMISSION_COMMENT = "comment";
    const PERMISSION_COMMENT_SELF = "comment.self";
    const PERMISSION_PORTFOLIO = "portfolio";
    const PERMISSION_ORDER_SELF = "order.self";
    const PERMISSION_ORDER = "comment";
}
