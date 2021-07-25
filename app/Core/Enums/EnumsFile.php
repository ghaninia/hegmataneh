<?php

namespace App\Core\Enums;

use App\Core\Abstracts\Enum;

class EnumsFile extends Enum
{

    const TYPE_FILE = "files";
    const TYPE_IMAGE = "images";

    const MIME_TYPE_IMAGE = [
        "image/jpeg",
        "image/png",
        "image/gif"
    ];

    const MIME_TYPE_FILE = [
        "image/svg",
        "image/svg+xml",
        "image/vnd.microsoft.icon",
        "video/x-msvideo",
        "text/css",
        "text/csv",
        "application/msword",
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
        "text/javascript",
        "application/json",
        "audio/mpeg",
        "video/mp4",
        "video/mpeg",
        "application/pdf",
        "application/vnd.rar",
        "application/x-tar",
        "text/plain",
        "audio/wav",
        "application/vnd.ms-excel",
        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        "application/xml",
        "application/zip",
        "video/3gpp"
    ];
}
