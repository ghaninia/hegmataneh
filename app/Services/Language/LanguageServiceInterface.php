<?php

namespace App\Services\Language;

use App\Models\Language;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\Paginator;

interface LanguageServiceInterface
{
    public function list(array $filters, bool $isPaginate = true): Paginator|Collection;
    public function create(array $data): Language;
    public function update(Language $language, array $data): Language;
    public function delete(Language $language): bool;
}
