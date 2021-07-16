<?php

namespace App\Core\Abstracts;

abstract class Enum
{
    /*
    ** تمام تایپ های که با type شروع میشود
    ** @return array
    */
    public static function type(): array
    {
        return self::reflaction("TYPE_");
    }

    /*
    ** تمام تایپ های که با format شروع میشود
    ** @return array
    */
    public static function format(): array
    {
        return self::reflaction("FORMAT_");
    }

    /*
    ** تمام تایپ های که با status شروع میشود
    ** @return array
    */
    public static function status(): array
    {
        return self::reflaction("STATUS_");
    }

    /*
    ** تمام ثابت های داخل کلاس
    ** @return array
    */
    public static function all(): array
    {
        return self::reflaction();
    }

    /**
     * لیست تمام پسوندها
     * @return array
     */
    public static function MIMES(): array
    {
        return array_merge(...self::reflaction("MIME_TYPE_"));
    }

    /*
    ** تمام ثابت های کلاس فعلی را دریافت مینماییم
    ** @param string    $key
    ** @return array
    */
    private static function reflaction(string $key = null): array
    {
        $consts = [];
        $reflect = new \ReflectionClass(new static);
        foreach ($reflect->getReflectionConstants() as $const) {
            if (is_null($key))
                $consts[] = $const->getValue();
            elseif (str_starts_with($const->getName(), $key))
                $consts[] = $const->getValue();
        }
        return $consts;
    }
}
