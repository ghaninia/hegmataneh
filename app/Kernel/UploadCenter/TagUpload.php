<?php

namespace App\Kernel\UploadCenter;

use App\Kernel\UploadCenter\Abstracts\UploadCenterAbstract;

class TagUpload extends UploadCenterAbstract
{
    public function serviceGuardName($name = null): string
    {
        return trans("dashboard.upload.guard.employee");
    }

    public function servicePathName($name = null): string
    {
        return trans("dashboard.upload.service.support");
    }
}
