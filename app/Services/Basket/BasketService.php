<?php

namespace App\Services\Basket;

use App\Models\User;
use App\Models\Basketable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Core\Interfaces\BasktableInterface;
use App\Repositories\Basket\BasketRepository;

class BasketService implements BasketServiceInterface
{
    protected $basketRepo ;

    protected $user , $request , $basket;

    public function __construct(BasketRepository $basketRepo)
    {
        $this->basketRepo = $basketRepo ;
    }

    /**
     * @param Request $request
     * @param User|null $user
     * @return $this
     */
    public  function basket( Request  $request , ?User $user = null ) : self
    {
        $this->user = $user ;
        $this->request = $request ;

        if( !! $user )
            $data["user_id"] = $user->id ;
        else
            $data["secret_key"] = $this->generateSecretKey($request);

       $this->basket = $this->basketRepo->firstOrCreate($data);

       return $this ;
    }

    /**
     * @param Request $request
     * @return string
     */
    private function generateSecretKey(Request $request )
    {
        return md5($request->ip());
    }

    /**
     * @param Request $request
     * @param User $user
     * @return $this
     */
    public function moveBasketItemGuestToUserWhenLoggin(Request  $request , User $user)
    {

        $localBasket = $this->basketRepo
            ->query()
            ->where(["secret_key" => $this->generateSecretKey($request) ])
            ->first() ;

        $this->basket($request , $user) ;

        if(isset($localBasket))
        {

            $userBasketables = $this->basket->basketables() ;
            $localBasketables = $localBasket->basketables ;

            $localBasketables->map(function($item) use ($user ,$userBasketables) {

                $unit = $item->unit ;

                $userBasketables->updateOrCreate([
                    "basketable_id" => $item->basketable_id ,
                    "basketable_type" => $item->basketable_type
                ],[
                    "unit" => DB::raw("unit + {$unit}")
                ]);

            });

            $localBasket->delete() ;
        }

        return $this;
    }

    /**
     * @param BasktableInterface $model
     * @param $unit
     * @return $this
     */
    public function appendItem(BasktableInterface $model , $unit )
    {

        $this->basket->basketables()->updateOrCreate([
            "basketable_id" => $model->id ,
            "basketable_type" => $model->getMorphClass()
        ],[
            "unit" => DB::raw("unit + $unit")
        ]);

        return $this;
    }

    /**
     * @param Basketable $basketable
     * @param $unit
     * @return $this
     */
    public function updateItem(Basketable $basketable , $unit )
    {
        $this->basket
            ->basketables()
            ->where("id" , $basketable->id)
            ->update([
                "unit" => $unit
            ]);

        if ($unit === 0)
            $this->delete($basketable) ;

        return $this;
    }

    /**
     * @param Basketable $basketable
     * @return $this
     */
    public function DeleteItem(Basketable $basketable )
    {
        $this->basket
            ->basketables()
            ->where("id" , $basketable->id )
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
                "products.prices" ,
            ]);
    }

}
