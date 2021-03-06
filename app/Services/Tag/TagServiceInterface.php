<?php

namespace App\Services\Tag;

use App\Kernel\Tag\Interfaces\TagableInterface;
use App\Models\Term;

interface TagServiceInterface
{
    public function updateOrCreate(array $data, Term $tag = null): Term ;
    public function delete(Term $tag): bool ;
    public function list(array $filters, bool $isPaginate = TRUE, array $relations = []) ;
    public function sync(TagableInterface $model, array $data = []): void ;

}
