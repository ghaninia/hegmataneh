<?php

namespace App\Services\Currency;

use App\Models\Currency;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\Paginator;
use App\Services\Currency\CurrencyServiceInterface;

class CurrencyService implements CurrencyServiceInterface
{

    /**
     * get list currencies
     * @param array $filters
     * @param bool $isPaginate
     * @return Paginator|Collection
     */
    public function list(array $filters, bool $isPaginate = true): Paginator|Collection
    {
        return
            Currency::query()
            ->filterBy($filters)
            ->when(
                $isPaginate,
                fn ($query) => $query->paginate(),
                fn ($query) => $query->get()
            );
    }

    /**
     * create or update currency
     * @param array $data
     * @param Currency|null $currency
     * @return Currency
     */
    public function updateOrCreate(array $data, Currency $currency = null): Currency
    {
        return
            Currency::updateOrCreate([
                "id" => $currency?->id
            ], [
                "name" => $data["name"],
                "code" => $data["code"] ?? null,
            ]);
    }

    /**
     * delete currency
     * @param Currency $currency
     * @return bool
     */
    public function delete(Currency $currency): bool
    {
        return Currency::whereId($currency->id)->delete();
    }
}
