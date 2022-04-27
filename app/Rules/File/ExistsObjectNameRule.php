<?php

namespace App\Rules\File;

use App\Models\File;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\UploadedFile;

class ExistsObjectNameRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(public User $user, public ?string $parentId = null)
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

        if (is_string($value)) {
            $value = $value;
        } elseif ($value instanceof UploadedFile) {
            $value = $value->getClientOriginalName();
        } else {
            return false;
        }

        return
            !File::where([
                "name" => $value,
                "user_id" => $this->user->id,
                "file_id" => $this->parentId
            ])->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans("dashboard.error.validation.exists_object_name");
    }
}
