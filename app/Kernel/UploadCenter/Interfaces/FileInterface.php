<?php

namespace App\Kernel\UploadCenter\Interfaces;

interface FileInterface
{
    public function fileable();
    public function delete();
    public function update(array $data);
}
