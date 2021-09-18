<?php

namespace App\Services\Currency;

use App\Models\Currency;
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
     * @return Paginator
     */
    public function list(array $filters): Paginator
    {
        return
            $this->currencyRepo->query()
            ->filterBy($filters)
            ->paginate();
    }

    /**
     * ساخت واحد پولی جدید
     * @param array $data
     * @return Currency
     */
    public function create(array $data): Currency
    {
        return
            $this->currencyRepo->create([
                "name" => $data["name"],
                "code" => $data["code"] ?? null ,
            ]);
    }

    /**
     * ویرایش واحد پولی
     * @param Currency $currency
     * @param array $data
     * @return Currency
     */
    public function update(Currency $currency, array $data): Currency
    {
        return
            $this->currencyRepo->updateById($currency->id, [
                "name" => $data["name"],
                "code" => $data["code"] ?? null ,
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
