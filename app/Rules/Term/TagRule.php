<?php

namespace App\Rules\Term;

use App\Repositories\Term\TermRepository;
use Illuminate\Contracts\Validation\Rule;

class TagRule implements Rule
{
    protected $termRepo;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->termRepo = app(TermRepository::class);
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
            $this->termRepo
            ->query()
            ->tags()
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
        return trans("dashboard.error.validation.tags");
    }
}
