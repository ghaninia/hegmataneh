<?php

namespace App\Kernel\Enums;

use App\Kernel\Enums\Abstracts\Enum;

class EnumsOrder extends Enum
{
    const STATUS_SUCCEDD = "succeed";
    const STATUS_FAILED = "failed";
    const STATUS_PENDDING = "pendding";
}
