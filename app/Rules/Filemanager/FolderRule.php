<?php

namespace App\Rules\Filemanager;

use App\Kernel\Enums\EnumsFile;
use App\Models\File;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class FolderRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(protected ?User $user = null){}

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return File::query()
            ->when(
                $this->user ,
                fn($query) => $query->where("user_id" , $this->user->id)
            )
            ->where("type" , EnumsFile::TYPE_FOLDER)
            ->exists() ;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
