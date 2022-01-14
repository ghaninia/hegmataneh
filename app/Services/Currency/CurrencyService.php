<?php

namespace App\Services\Currency;

use App\Models\Currency;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\Paginator;
use App\Repositories\Currency\CurrencyRepository;
use App\Services\Currency\CurrencyServiceInterface;

class CurrencyService implements CurrencyServiceInterface
{
    protected $currencyRepo;

    public function __construct(CurrencyRepository $currencyRepo)
    {
        $this->currencyRepo = $currencyRepo;
    }

    /**
     * لیست واحد پولی ها
     * @param array $filters
     * @param bool $isPaginate
     * @return Paginator
     */
    public function list(array $filters, bool $isPaginate = true): Paginator|Collection
    {
        return
            $this->currencyRepo->query()
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
            $this->currencyRepo->updateOrCreate([
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
        return $this->currencyRepo->delete($currency);
    }
}
