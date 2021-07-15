<?php

namespace App\Core\Traits;

use Illuminate\Http\JsonResponse;

trait MessageTrait
{

    /**
     * پیغام موفقیت آمیز
     * @param array $data
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function success(array $data, int $statusCode = 200): JsonResponse
    {
        $data["ok"] = TRUE;
        return response()->json(
            $data,
            $statusCode
        );
    }

    /**
     * پیغام خطا
     * @param array $data
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function error(array $data, int $statusCode = 400): JsonResponse
    {
        $data["ok"] = FALSE;
        return response()->json(
            $data,
            $statusCode
        );
    }
}
