<?php

namespace App\Kernel\UploadCenter\Classes;

use App\Kernel\UploadCenter\Interfaces\FileInterface;
use App\Models\File;

class FileModelCenter
{
    protected bool $pull = false;

    protected static array $dataUploads = [];

    public function pull()
    {
        $this->pull = true;
        return $this;
    }

    /**
     * FINAL UPLOAD FILES
     */
    public function upload()
    {

        if ($this->pull) {

            $this->fileable
                ->files()
                ->when(isset($this->tag), fn ($query) => $query->where("tag", $this->tag))
                ->get()
                ->each
                ->delete();
        }

        if (count(self::$dataUploads)) {

            $files = $this->fileable->files()->createMany(self::$dataUploads);

            self::$dataUploads = [];

            return $files;
        }

        return FALSE;
    }

    /**
     * change driver
     */
    protected function changeDisk(FileInterface $file, $disk)
    {
        return $file->update(["disk" => $disk]);
    }

    /**
     * model delete
     */
    protected function deleteFromDatabase(FileInterface $file)
    {
        return $file->delete();
    }

    /**
     * model update
     * @param File $file
     * @param array $data
     *
     * @return bool
     */
    protected function update(File $file, array $data): bool
    {
        return $file->update($data);
    }
}
