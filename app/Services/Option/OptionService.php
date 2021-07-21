<?php

namespace App\Services\Option;

use App\Models\Option;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use App\Repositories\Option\OptionRepository;
use App\Services\Option\OptionServiceInterface;

class OptionService implements OptionServiceInterface
{

    ## زمان اکسپایر شدن بر اساس ثانیه
    const EXPIRE_TIME = 600;

    ## نام قراردادی کش
    const CACHE_NAME = "options_cache";

    protected static $instances;

    private function __construct()
    {
    }

    public static function getInstance(): self
    {
        $cls = new self();
        if (is_null(self::$instances)) {
            self::$instances = $cls->getRecordsInCache();
        }
        return $cls;
    }

    /**
     * سرویسی که قرار است روی آن سینگلتون را اجرا نماییم
     * @return OptionRepository
     */
    public function service(): OptionRepository
    {
        return app(OptionRepository::class);
    }

    /**
     * دریافت اطلاعات از کش
     * @return mixed
     */
    protected function getRecordsInCache()
    {
        if (!Cache::has(self::CACHE_NAME)) {
            $records = $this->getRecordesInDatabase();
            $records = serialize($records);
            Cache::put(self::CACHE_NAME, $records, self::EXPIRE_TIME);
        }
        $cache = Cache::get(self::CACHE_NAME);
        return unserialize($cache);
    }

    /**
     * رکورد مای مورد نظر جهت ذخیره در کش
     * @return Collection
     */
    public function getRecordesInDatabase(): array
    {
        return $this->service()->all([
            "key", "value", "default"
        ])->toArray();
    }

    /**
     * @param string $key
     * @param $default
     * @return array|string
     */
    public function get(string $key, $default = null)
    {
        $data = collect(self::$instances)->where("key", $key)->first();

        return (!!$data["value"] ? unserialize($data["value"]) : null) ??
            $default ??
            $data["default"];
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return Option
     */
    public function put(string $key,  $value) : Option
    {
        return $this->service()->updateOrCreate($key, serialize($value));
    }


    /**
     * @return boolean
     */
    public function forget(): bool
    {
        return Cache::forget(self::CACHE_NAME);
    }
}
