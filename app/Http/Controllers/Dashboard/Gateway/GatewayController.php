<?php

namespace App\Http\Controllers\Dashboard\Gateway;

use App\Models\Gateway;
use App\Http\Controllers\Controller;
use App\Http\Requests\Gateway\GatewayIndex;
use App\Http\Requests\Gateway\GatewayStore;
use App\Http\Requests\Gateway\GatewayUpdate;
use App\Http\Requests\Gateway\GatewayDestroy;
use App\Http\Resources\Gateway\GatewayResource;
use App\Http\Resources\Gateway\GatewayCollection;
use App\Services\Gateway\GatewayServiceInterface;

class GatewayController extends Controller
{
    public function __construct(
        public GatewayServiceInterface $gatewayService
    ){}

    /**
     * Display a listing of the resource
     * @param GatewayIndex $request
     * @return GatewayCollection
     */
    public function index(GatewayIndex $request)
    {

        $gateways = $this->gatewayService->list(
            $request->only([
                "id", "key", "name", "status"
            ]),
            $request->input("is_paginate") ?? FALSE,
            ["currencies"]
        );

        return new GatewayCollection($gateways);
    }

    /**
     * Store a newly created resource in storage
     * @param GatewayStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(GatewayStore $request)
    {

        $gateway = $this->gatewayService->updateOrCreate(
            $request->only([
                "code", "name", "status", "currencies"
            ]),
        );

        return $this->success([
            "msg" => trans("dashboard.success.gateway.create"),
            "data" => new GatewayResource($gateway->load("currencies"))
        ]);
    }

    /**
     * Display the specified resource.
     * @param Gateway $gateway
     * @return GatewayResource
     */
    public function show(Gateway $gateway)
    {
        return new GatewayResource($gateway->load("currencies"));
    }

    /**
     * Update the specified resource in storage
     * @param Gateway $gateway
     * @param GatewayUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Gateway $gateway, GatewayUpdate $request)
    {

        $gateway = $this->gatewayService->updateOrCreate(
            $request->only([
                "code", "name", "status", "currencies"
            ]),
            $gateway
        );

        return $this->success([
            "msg" => trans("dashboard.success.gateway.update"),
            "data" => new GatewayResource($gateway->load("currencies"))
        ]);
    }

    /**
     * Remove the specified resource from storage
     * @param Gateway $gateway
     * @param GatewayDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Gateway $gateway, GatewayDestroy $request)
    {
        $this->gatewayService->delete($gateway);
        return $this->success([
            "msg" => trans("dashboard.success.gateway.delete")
        ]);
    }
}
