<?php

namespace App\Core\Traits;

use Illuminate\Database\Eloquent\Model;

trait OtherBaseRepository
{
    public function query()
    {
        return $this->model;
    }

    public function updateOrCreate($except, $data)
    {
        return $this->model->updateOrCreate($except, $data);
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
