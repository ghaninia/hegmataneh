<?php

namespace App\Rules;

use Exception;
use Illuminate\Contracts\Validation\Rule;

class SlugRule implements Rule
{

    protected $modelClass, $field, $routeParameter;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(string $modelClass, string $field, $routeParameter = null)
    {
        $this->modelClass = $modelClass;
        $this->field = $field;
        $this->routeParameter = $routeParameter;
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
        try {
            $field = request($this->field);

            if (
                (is_null($field) && is_null($value))
            )
                return false;

            $slug = slug($value, $field);

            return !$this->modelClass::query()
                ->where("slug", $slug)
                ->when( !! $this->routeParameter , function ($qury) {
                    $qury->where("id", "<>", $this->routeParameter->id);
                })
                ->exists();

        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans("dashboard.error.validation.slug");
    }
}
