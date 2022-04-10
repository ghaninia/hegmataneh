<?php

namespace App\Http\Controllers\Dashboard\Serial;

use App\Models\User;
use App\Models\Serial;
use App\Http\Controllers\Controller;
use App\Services\Price\PriceService;
use App\Services\Serial\SerialService;
use App\Http\Requests\Serial\SerialIndex;
use App\Http\Requests\Serial\SerialRequest;
use App\Http\Resources\Serial\SerialResource;
use App\Http\Resources\Serial\SerialCollection;

class SerialController extends Controller
{

    public function __construct(
        protected SerialService $serialService,
        protected PriceService $priceService
    ){
    }

    /**
     * Display a listing of the resource
     * @param User $user
     * @param SerialIndex $request
     * @return SerialCollection
     */
    public function index(User $user, SerialIndex $request)
    {
        $filters = array_merge(
            ["user" => $user->id],
            $request->only([
                "title",
                "created_at",
                "price",
                "posts",
                "amazing_price",
            ])
        );

        $serials = $this->serialService->list($filters);

        return  new SerialCollection($serials);
    }

    /**
     * Store a newly created resource in storage
     * @param User $user
     * @param SerialRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(User $user, SerialRequest $request)
    {

        $serial = $this->serialService->updateOrCreate(
            $user,
            $request->all()
        );

        return $this->success([
            "msg" => trans("dashboard.success.serial.create"),
            "data" => new SerialResource($serial)
        ]);
    }

    /**
     * Display the specified resource
     * @param User $user
     * @param Serial $serial
     * @return SerialResource
     */
    public function show(User $user, Serial $serial)
    {
        return new SerialResource(
            $serial->load(["prices", "episodes.post"])
        );
    }

    /**
     * Update the specified resource in storage
     * @param User $user
     * @param Serial $serial
     * @param SerialRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(User $user, Serial $serial, SerialRequest $request)
    {

        $serial = $this->serialService->updateOrCreate(
            $user,
            $request->all(),
            $serial
        );

        return $this->success([
            "msg" => trans("dashboard.success.serial.update"),
            "data" => new SerialResource($serial)
        ]);
    }

    /**
     * Remove the specified resource from storage
     * @param User $user
     * @param Serial $serial
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user, Serial $serial)
    {
        $this->serialService->delete($serial);

        return $this->success([
            "msg" => trans("dashboard.success.serial.delete")
        ]);
    }
}
