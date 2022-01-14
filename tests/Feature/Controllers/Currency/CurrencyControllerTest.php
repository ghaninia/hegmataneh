<?php

namespace Tests\Feature\Controllers\Currency;

use Tests\TestCase;
use App\Models\User;
use App\Models\Currency;
use Illuminate\Http\Response;

class CurrencyControllerTest extends TestCase
{
    protected User $authUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authUser = $this->signIn();
    }

    public function testGetSystemCurrency()
    {

        $currencies = Currency::factory()
            ->count($total = random_int(1, 5))
            ->create();

        $currency = $currencies->first();

        $response = $this->getJson(route('api.v1.currency.index', [
            "name" => $currency->name,
            "code" => $currency->code,
        ]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                "data" => [
                    "*" => [
                        "id",
                        "code",
                        "name",
                    ]
                ]
            ]);

        $response = $this->getJson(route('api.v1.currency.index', [
            "name" => $currency->name,
            "code" => $currency->code,
            "is_paginate" => TRUE
        ]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                "meta",
                "links",
                "data" => [
                    "*" => [
                        "id",
                        "code",
                        "name",
                    ]
                ]
            ]);
    }

    public function testCreateNewCurrency()
    {
        $currency = Currency::factory()->make();

        $response = $this->postJson(
            route('api.v1.currency.store'),
            $currency->toArray()
        );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                "data" => [
                    "id",
                    "code",
                    "name",
                ]
            ])
            ->assertJsonPath("data.name", $currency->name)
            ->assertJsonPath("data.code", $currency->code);

        $this->assertDatabaseHas("currencies", $currency->toArray());
    }

    public function testUpdateCurrency()
    {
        $currency = Currency::factory()->create();

        $newCurrency = Currency::factory()->make();

        $response = $this->putJson(
            route('api.v1.currency.update', $currency),
            $newCurrency->toArray()
        );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonPath("data.name", $newCurrency->name)
            ->assertJsonPath("data.code", $newCurrency->code);

        $this->assertDatabaseHas("currencies", [
            "id" => $currency->id,
            "name" => $newCurrency->name,
            "code" => $newCurrency->code,
        ]);
    }

    public function testShowCurrency()
    {
        $currency = Currency::factory()->create();

        $response = $this->getJson(
            route('api.v1.currency.show', $currency)
        );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                "data" => [
                    "id",
                    "code",
                    "name",
                ]
            ])
            ->assertJsonPath("data.name", $currency->name)
            ->assertJsonPath("data.code", $currency->code);
    }


    public function testDeleteCurrency()
    {
        $currency = Currency::factory()->create();

        $response = $this->deleteJson(
            route('api.v1.currency.destroy', $currency)
        );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                "ok",
                "msg"
            ]);

        $this->assertDatabaseMissing("currencies", [
            "id" => $currency->id,
            "name" => $currency->name,
            "code" => $currency->code,
        ]);
    }
}
