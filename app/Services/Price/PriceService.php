<?php

namespace App\Services\Price;

use App\Models\Price;
use Illuminate\Database\Eloquent\Model;
use App\Services\Price\PriceServiceInterface;

class PriceService implements PriceServiceInterface
{

    public function create(Model $model, array $currencies) : void
    {
        array_walk($currencies, function ($data, $currencyID) use ($model) {
            Price::updateOrCreate([
                "priceable_id" => $model->id,
                "priceable_type" => $model->getMorphClass(),
                "currency_id" => $currencyID
            ], [
                "price" => (int) $data["price"] ?? 0,
                "amazing_status" => $data["amazing_status"] ?? FALSE,
                "amazing_price" => $data["amazing_price"] ?? 0,
                "amazing_from_date" => $data["amazing_from_date"] ?? null,
                "amazing_to_date" => $data["amazing_to_date"] ?? null,
            ]);
        });
    }
}
