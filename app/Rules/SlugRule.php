<?php

namespace App\Rules;

use App\Kernel\Slug\Interfaces\SlugableInterface;
use App\Models\Slug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Validation\Rule;

class SlugRule implements Rule
{

    protected Model|null $except;
    protected SlugableInterface $class;

    public function __construct(string $class, Model $except = null)
    {
        $this->class = new $class;
        $this->except = $except;
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

        $morphClassName = (string) $this->class->getMorphClass();

        $result =
            Slug::query()
            ->where([
                "slugable_type" => $morphClassName,
                "slug" => slug($value)
            ])
            ->when(!!$this->except, function ($query) use ($morphClassName, $value) {
                $query->where(function ($query)  use ($morphClassName, $value) {
                    $query
                        ->where([
                            "slugable_type" => $morphClassName,
                            "slug" => slug($value)
                        ])
                        ->where("slugable_id", "<>", $this->except->id);
                });
            })
            ->exists();

        return !$result;
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
