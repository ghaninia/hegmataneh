<?php

namespace App\Services\Gateway;

use App\Models\Gateway;
use App\Repositories\Gateway\GatewayRepository;
use App\Services\Gateway\GatewayServiceInterface;

class GatewayService implements GatewayServiceInterface
{

    public function __construct(protected GatewayRepository $gatewayRepo)
    {
    }

    /**
     * دریافت لیست درگاه ها
     * @param array $filters
     * @param bool $isPaginate
     * @param array $withs
     */
    public function list(array $filters, bool $isPaginate = true, array $withs = [])
    {
        return
            $this->gatewayRepo->query()
            ->filterBy($filters)
            ->when(
                count($withs),
                fn ($query) => $query->with($withs)
            )
            ->when(
                $isPaginate,
                fn ($query) => $query->paginate(),
                fn ($query) => $query->get()
            );
    }

    /**
     * ویرایش و آپدیت درگاه های بانکی
     * @param array $data
     * @param Gateway|null $gateway
     */
    public function updateOrCreate(array $data, Gateway $gateway = null)
    {

        $gateway =
            $this->gatewayRepo->updateOrCreate([
                "id" => $gateway?->id
            ], [
                "status" => $data["status"],
                "name" => $data["name"],
                "code" => $data["code"],
            ]);

        $gateway->currencies()->sync($data["currencies"] ?? []);

        return $gateway;
    }

    /**
     *
     * @param Gateway $gateway
     */
    public function delete(Gateway $gateway)
    {
        return $gateway->delete();
    }


    /**
     * آیا فاکتوری با این درگاه صادر شده است ؟
     * @param Gateway $gateway
     */
    public function hasOrders(Gateway $gateway)
    {
        return (bool) $gateway->orders()->count();
    }
}
