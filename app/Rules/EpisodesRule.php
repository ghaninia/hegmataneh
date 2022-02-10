<?php

namespace App\Rules;

use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class EpisodesRule implements Rule
{
    protected $user;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(?User $user = null)
    {
        $this->user = $user;
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

        $countPosts = Post::query()
            ->posts()
            ->withTrashed()
            ->where("user_id", $this->user->id)
            ->whereIn("id", $keys)
            ->count();

        return $countPosts === count($keys);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans("dashboard.error.validation.post-serial-access");
    }
}
