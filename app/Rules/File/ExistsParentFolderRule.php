<?php

namespace App\Rules\File;

use App\Models\File;
use App\Models\User;
use App\Core\Enums\EnumsFile;
use Illuminate\Contracts\Validation\Rule;

class ExistsParentFolderRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(public User $user)
    {
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
        return !File::where([
            "id" => $value,
            "user_id" => $this->user->id,
            "type" => EnumsFile::TYPE_FOLDER
        ])->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans("dashboard.error.validation.exists_parent_folder");
    }
}
