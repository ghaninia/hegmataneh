<?php

namespace App\Observers;

class EpisodeObserver
{
    public function delete($model)
    {
        $model->translations()->delete();
    }
}
