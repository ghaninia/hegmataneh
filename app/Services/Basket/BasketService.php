<?php

namespace App\Services\Basket;

use App\Models\User;
use App\Models\Basket;
use App\Models\Basketable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Kernel\Basket\Interfaces\BasktableInterface;

class BasketService implements BasketServiceInterface
{
    protected $user, $request, $basket;

    /**
     * get user shop basket
     * @param Request $request
     * @param User|null $user
     * @return $this
     */
    public  function basket(Request  $request, ?User $user = null): self
    {
        $this->user = $user;
        $this->request = $request;

        if (!!$user)
            $data["user_id"] = $user->id;
        else
            $data["secret_key"] = $this->generateSecretKey($request);

        $this->basket = Basket::query()->firstOrCreate($data);

        return $this;
    }

    /**
     * create secret key
     * @param Request $request
     * @return string
     */
    private function generateSecretKey(Request $request)
    {
        return md5($request->ip());
    }

    /**
     * Move guest SHOP cart to user profile
     * @param Request $request
     * @param User $user
     * @return $this
     */
    public function moveBasketItemGuestToUserWhenLoggin(Request  $request, User $user)
    {

        $localBasket = Basket::query()
            ->where(["secret_key" => $this->generateSecretKey($request)])
            ->first();

        $this->basket($request, $user);

        if (isset($localBasket)) {

            $userBasketables = $this->basket->basketables();
            $localBasketables = $localBasket->basketables;

            $localBasketables->map(function ($item) use ($user, $userBasketables) {

                $unit = $item->unit;

                $userBasketables->updateOrCreate([
                    "basketable_id" => $item->basketable_id,
                    "basketable_type" => $item->basketable_type
                ], [
                    "unit" => DB::raw("unit + {$unit}")
                ]);
            });

            $localBasket->delete();
        }

        return $this;
    }

    /**
     * Append new item
     * @param BasktableInterface $model
     * @param $unit
     * @return $this
     */
    public function appendItem(BasktableInterface $model, $unit)
    {

        $this->basket->basketables()->updateOrCreate([
            "basketable_id" => $model->id,
            "basketable_type" => $model->getMorphClass()
        ], [
            "unit" => DB::raw("unit + $unit")
        ]);

        return $this;
    }

    /**
     * update shop item
     * @param Basketable $basketable
     * @param $unit
     * @return $this
     */
    public function updateItem(Basketable $basketable, $unit)
    {
        $this->basket
            ->basketables()
            ->where("id", $basketable->id)
            ->update([
                "unit" => $unit
            ]);

        if ($unit === 0)
            $this->delete($basketable);

        return $this;
    }

    /**
     * delete shop cart item
     * @param Basketable $basketable
     * @return $this
     */
    public function DeleteItem(Basketable $basketable)
    {
        $this->basket
            ->basketables()
            ->where("id", $basketable->id)
            ->delete();

        return $this;
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return
            $this->basket->load([
                "serials.prices",
                "products.prices",
            ]);
    }
}
