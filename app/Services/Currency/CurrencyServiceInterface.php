<?php

namespace App\Services\Currency;

use App\Models\Currency;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\Paginator;

interface CurrencyServiceInterface
{
    public function list(array $filters, bool $isPaginate = true): Paginator|Collection;
    public function updateOrCreate(array $data, Currency $currency = null): Currency;
    public function delete(Currency $currency): bool;
}
