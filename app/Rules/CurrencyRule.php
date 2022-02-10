<?php

namespace App\Rules;

use App\Models\Currency;
use Illuminate\Contracts\Validation\Rule;

class CurrencyRule implements Rule
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
        $keys = array_keys(
            is_array($value) ? $value : [$value]
        );

        $countCurrencies = Currency::query()
            ->whereIn("id", $keys)
            ->count();

        return $countCurrencies === count($keys);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans("dashboard.error.validation.currency");
    }
}
