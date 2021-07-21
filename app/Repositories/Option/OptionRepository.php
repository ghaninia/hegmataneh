<?php

namespace App\Repositories\Option;

use App\Models\Option;
use App\Repositories\Option\OptionRepositoryInterface;
use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;

class OptionRepository extends BaseRepository implements OptionRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Option::class;
    }

    /**
     * @param string $key
     * @param $value
     * @return Option
     */
    public function updateOrCreate($key, $value) : Option
    {
        return
            $this->model->updateOrCreate(
                ["key" => $key],
                [
                    "key" => $key,
                    "value" => $value
                ]
            );
    }
}
