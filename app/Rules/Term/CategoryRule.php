<?php

namespace App\Rules\Term;

use App\Models\Term;
use Illuminate\Contracts\Validation\Rule;

class CategoryRule implements Rule
{


    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return
            Term::query()
            ->categories()
            ->where("id", $value)
            ->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans("dashboard.error.validation.categories");
    }
}
