<?php

namespace App\Http\Controllers\Api\Currency;

use App\Models\Currency;
use App\Http\Controllers\Controller;
use App\Http\Requests\Currency\CurrencyIndex;
use App\Http\Requests\Currency\CurrencyStore;
use App\Http\Requests\Currency\CurrencyUpdate;
use App\Http\Resources\Currency\CurrencyResource;
use App\Http\Resources\Currency\CurrencyCollection;
use App\Services\Currency\CurrencyServiceInterface;

class CurrencyController extends Controller
{
    protected $currencyService;

    public function __construct(CurrencyServiceInterface $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    /**
     * Display a listing of the resource.
     * @param CurrencyIndex $request
     * @return \Illuminate\Http\Response
     */
    public function index(CurrencyIndex $request)
    {

        $currencies = $this->currencyService->list(
            $request->only([
                "name",
                "code",
            ]),
            $request->input("is_paginate") ?? FALSE
        );

        return new CurrencyCollection($currencies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CurrencyStore $request
     * @return \Illuminate\Http\Response
     */
    public function store(CurrencyStore $request)
    {
        $currency =
            $this->currencyService->updateOrCreate(
                $request->only([
                    "name",
                    "code",
                ])
            );

        return $this->success([
            "msg" => trans("dashboard.success.currency.create"),
            "data" => new CurrencyResource($currency)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Currency $currency
     * @return \Illuminate\Http\Response
     */
    public function show(Currency $currency)
    {
        return new CurrencyResource($currency);
    }

    /**
     * Update the specified resource in storage.
     * @param  Currency $currency
     * @param  CurrencyUpdate $request
     * @return \Illuminate\Http\Response
     */
    public function update(Currency $currency, CurrencyUpdate $request)
    {
        $currency =
            $this->currencyService->updateOrCreate(
                $request->only([
                    "name",
                    "code",
                ]),
                $currency,
            );

        return $this->success([
            "msg" => trans("dashboard.success.currency.update"),
            "data" => new CurrencyResource($currency)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Currency $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Currency $currency)
    {
        $this->currencyService->delete($currency);

        return $this->success([
            "msg" => trans("dashboard.success.currency.delete")
        ]);
    }
}
