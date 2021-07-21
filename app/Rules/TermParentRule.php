<?php

namespace App\Rules;

use App\Models\Term;
use Illuminate\Contracts\Validation\Rule;

class TermParentRule implements Rule
{

    protected $routeParent;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($routeParent = null)
    {
        $this->routeParent = $routeParent;
    }

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
            ->when(!!$this->routeParent, function ($query) use ($value) {
                $query
                    ->where("id", "<>", $this->routeParent->id);
            })
            ->get();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans("dashboard.error.validation.term_id");
    }
}
