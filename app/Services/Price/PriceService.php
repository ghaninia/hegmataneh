<?php

namespace App\Services\Price;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Price\PriceRepository;
use App\Services\Price\PriceServiceInterface;

class PriceService implements PriceServiceInterface
{

    protected $priceRepo;

    public function __construct(PriceRepository $priceRepo)
    {
        $this->priceRepo = $priceRepo;
    }

    public function create(Model $model, array $data)
    {
        return
            $this->priceRepo->updateOrCreate([
                "priceable_id" => $model->id,
                "priceable_type" => $model->getMorphClass(),
            ], [
                "price" => (int) $data["price"] ?? 0,
                "amazing_status" => $data["amazing_status"] ?? FALSE,
                "amazing_price" => $data["amazing_price"] ?? 0,
                "amazing_from_date" => $data["amazing_from_date"] ?? null,
                "amazing_to_date" => $data["amazing_to_date"] ?? null,
            ]);
    }
}
