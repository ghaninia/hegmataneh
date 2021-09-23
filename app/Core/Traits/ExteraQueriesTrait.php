<?php

namespace App\Core\Traits;

use Illuminate\Database\Eloquent\Model;

trait ExteraQueriesTrait
{
    public function query()
    {
        return $this->model;
    }

    public function updateOrCreate(array $condition, array $data)
    {
        return $this->model->updateOrCreate($condition, $data);
    }

    public function restore(Model $model)
    {
        return $model->restore($model);
    }

    public function forceDelete(Model $model)
    {
        return $model->forceDelete();
    }

    public function firstOrCreate(... $parameters )
    {
        return $this->model->firstOrCreate(...$parameters) ;
    }

}
