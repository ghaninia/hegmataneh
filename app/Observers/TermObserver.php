<?php

namespace App\Observers;

use App\Models\Term;

class TermObserver
{
    /**
     * @param Term $term
     * @return void
     */
    public function deleted(Term $term) : void
    {
        $term->posts()->delete();
        $term->childrens()->delete();
    }
}
