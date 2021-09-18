<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Repositories\Currency\CurrencyRepository;

class CurrencyRule implements Rule
{

    protected $currencyRepo ;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->currencyRepo = app(CurrencyRepository::class);
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
        $keys = array_keys(
            is_array($value) ? $value : [$value]
        );

        $countCurrencies = $this
            ->currencyRepo
            ->query()
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
