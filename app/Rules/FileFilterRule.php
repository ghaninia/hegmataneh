<?php

namespace App\Rules;

use App\Models\User;
use App\Services\File\FileService;
use Illuminate\Contracts\Validation\Rule;

class FileFilterRule implements Rule
{
    protected $fileService;

    /**
     * Create a new rule instance.
     *
     * @param User|null $user
     * @param array $mimes
     */
    public function __construct(public ?User $user = null, public array $mimes)
    {
        $this->fileService = app(FileService::class);
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
            $this->fileService->canUseFile(
                $this->user,
                $value,
                $this->mimes
            );
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans("dashboard.error.validation.unauthorize_file");
    }
}
