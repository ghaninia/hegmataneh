<?php

namespace App\Services\Gateway;

use App\Models\Gateway;
use App\Services\Gateway\GatewayServiceInterface;

class GatewayService implements GatewayServiceInterface
{

    /**
     * get all gateway list
     * @param array $filters
     * @param bool $isPaginate
     * @param array $withs
     * @return mixed
     */
    public function list(array $filters, bool $isPaginate = true, array $withs = [])
    {
        return
            Gateway::query()
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
     * create or update gateway
     * @param array $data
     * @param Gateway|null $gateway
     * @return mixed
     */
    public function updateOrCreate(array $data, Gateway $gateway = null)
    {

        $gateway =
            Gateway::updateOrCreate([
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
     * delete gateway
     * @param Gateway $gateway
     * @return bool|null
     */
    public function delete(Gateway $gateway)
    {
        return $gateway->delete();
    }


    /**
     * Has an invoice been issued with this port?
     * @param Gateway $gateway
     * @return bool
     */
    public function hasOrders(Gateway $gateway)
    {
        return (bool) $gateway->orders()->count();
    }
}
