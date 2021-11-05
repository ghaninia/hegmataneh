<?php

namespace App\Observers;

use App\Models\Term;

class TermObserver
{
    /**
     * @param Term $term
     * @return void
     */
    public function deleted(Term $term): void
    {
        $term->posts()->detach();
        $term->childrens()->delete();
        $term->translations()->delete();
        $term->slugs()->delete();
    }
}
