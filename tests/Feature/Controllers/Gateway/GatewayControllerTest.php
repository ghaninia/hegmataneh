<?php

namespace Tests\Feature\Controllers\Gateway;

use Tests\TestCase;
use App\Models\User;
use App\Models\Gateway;
use App\Models\Currency;
use Illuminate\Http\Response;

class GatewayControllerTest extends TestCase
{

    protected User $authUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authUser = $this->signIn();
    }

    /** @test */
    public function getTheListGateways()
    {

        $gateways =
            Gateway::factory()
            ->count($total = random_int(1, 5))
            ->create();

        $gateway = $gateways->first();

        $response = $this->getJson(route('api.v1.gateway.index', [
            "id" => $gateway->id,
            "status" => $gateway->status,
            "name" => $gateway->name,
            "code" => $gateway->code,
        ]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonMissing([
                "links",
                "meta"
            ])
            ->assertJsonStructure([
                "data" => [
                    "*" => [
                        "id",
                        "name",
                        "code",
                        "status",
                        "currencies"
                    ]
                ],
            ])
            ->assertJsonCount(1, "data");
    }

    /** @test */
    public function createNewGateway()
    {

        $gateway = Gateway::factory()->make();

        $currencies = Currency::factory()
            ->count($totalCurrencies = random_int(1, 5))
            ->create();

        $response = $this->postJson(
            route('api.v1.gateway.store'),
            $gateway->toArray() + [
                "currencies" => $currencies->pluck("id")->toArray()
            ]
        );

        $this->assertDatabaseHas(
            "gateways",
            $gateway->toArray()
        );

        $this->assertDatabaseCount(
            "currency_gateway",
            $totalCurrencies
        );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                "data" => [
                    "id",
                    "name",
                    "code",
                    "status",
                ]
            ])
            ->assertJson([
                "data" => [
                    "name" => $gateway->name,
                    "code" => $gateway->code,
                    "status" => $gateway->status,
                    "currencies" => []
                ]
            ]);
    }

    /** @test */
    public function showGateway()
    {

        $gateway = Gateway::factory()
            ->hasAttached(
                Currency::factory()->count($totalCurrencies = random_int(1, 5)),
                [],
                "currencies"
            )
            ->create();

        $response = $this->getJson(
            route('api.v1.gateway.show', [
                "gateway" => $gateway->id
            ])
        );

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                "data" => [
                    "id",
                    "name",
                    "code",
                    "status",
                    "currencies" => [
                        "*" => [
                            "id",
                            "name",
                            "code",
                        ]
                    ]
                ]
            ])
            ->assertJson([
                "data" => [
                    "name" => $gateway->name,
                    "code" => $gateway->code,
                    "status" => $gateway->status,
                ]
            ])
            ->assertJsonCount($totalCurrencies, "data.currencies");
    }


    /** @test */
    public function updateGateway()
    {
        $gateway = Gateway::factory()
            ->create();

        $newGateway = Gateway::factory()->make();

        $newCurrencies = Currency::factory()
            ->count($totalCurrencies = random_int(1, 5))
            ->create();

        $response = $this->putJson(
            route("api.v1.gateway.update", [
                "gateway" => $gateway->id
            ]),
            $newGateway->toArray() + [
                "currencies" => $newCurrencies->pluck("id")->toArray()
            ]
        );

        $this->assertDatabaseCount(
            "currency_gateway",
            $totalCurrencies
        );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                "data" => [
                    "id",
                    "name",
                    "code",
                    "status",
                ]
            ])
            ->assertJson([
                "data" => [
                    "name" => $newGateway->name,
                    "code" => $newGateway->code,
                    "status" => $newGateway->status,
                ]
            ]);
    }


    /** @test */
    public function deleteGateway()
    {
        $gateway = Gateway::factory()
            ->hasAttached(
                Currency::factory()->count($totalCurrencies = random_int(1, 5)),
                [],
                "currencies"
            )
            ->create();

        $response = $this->deleteJson(
            route("api.v1.gateway.destroy", [
                "gateway" => $gateway->id
            ])
        );

        $response->assertStatus(Response::HTTP_OK)->assertJsonStructure([
            "ok" , "msg"
        ]);

        $this->assertDatabaseMissing(
            "gateways",
            [
                "id" => $gateway->id
            ]
        );
    }
}
