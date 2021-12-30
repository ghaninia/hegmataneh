<?php

namespace App\Core\Enums;

use App\Core\Abstracts\Enum;

class EnumsFileable extends Enum
{
    const USAGE_PRV_FILE = "private_file";
    const USAGE_PUB_FILE = "public_file";
    const USAGE_THUMBNAIL = "thumbnail";
    const USAGE_COVER = "cover";
    const USAGE_GALLERY = "gallery";
}
