<?php

namespace App\Policies;

use App\Models\File;
use App\Models\User;
use App\Core\Enums\EnumsFile;
use Illuminate\Auth\Access\HandlesAuthorization;

class FilePolicy
{
    use HandlesAuthorization;

    /**
     * access folder for user
     * @param User $user
     * @param File $file
     * @return bool
     */
    public function dir(User $user, File $file = null)
    {
        return !! $file ? (
            $file->type === EnumsFile::TYPE_FOLDER &&
            $file->user_id === $user->id
        ) : true ; 
    }

    /**
     * access to file or folder
     * @param User $user
     * @param File $file
     * @return bool
     */
    public function file(User $user, File $file)
    {
        return $file->user_id === $user->id;
    }

}
