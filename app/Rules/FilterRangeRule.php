<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FilterRangeRule implements Rule
{

    protected $support = [
        "lte",
        "gte",
        "lt",
        "gt",
    ];

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $validate = [];

        if (is_array($value)) {
            foreach ($value as $key => $val) {
                $validate[] = in_array($key, $this->support);
                $validate[] = is_string($val);
            }
        }

        return !in_array(FALSE , $validate) ;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans("dashboard.error.validation.range");
    }
}
