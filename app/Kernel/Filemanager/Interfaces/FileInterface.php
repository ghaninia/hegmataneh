<?php

namespace App\Kernel\Filemanager\Interfaces;

interface FileInterface
{
    public function delete();
    public function update(array $data);
}
