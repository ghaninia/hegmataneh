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

    public function restore(Model $post)
    {
        return $this->model->restore($post);
    }

    public function forceDelete(Model $post)
    {
        return $this->model->forceDelete($post);
    }
}
