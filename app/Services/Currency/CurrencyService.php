<?php

namespace App\Services\Currency;

use App\Models\Currency;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\Paginator;
use App\Services\Currency\CurrencyServiceInterface;

class CurrencyService implements CurrencyServiceInterface
{

    /**
     * لیست واحد پولی ها
     * @param array $filters
     * @param bool $isPaginate
     * @return Paginator
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
     * ساخت و ویرایش واحد پولی
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
     * حذف واحد پولی
     * @param Currency $currency
     * @return boolean
     */
    public function delete(Currency $currency): bool
    {
        return Currency::whereId($currency->id)->delete();
    }
}
