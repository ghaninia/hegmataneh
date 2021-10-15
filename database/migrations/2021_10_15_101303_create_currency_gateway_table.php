<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrencyGatewayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency_gateway', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("currency_id");
            $table->unsignedBigInteger("gateway_id");

            $table->foreign("gateway_id")->on("gateways")->references("id")->onDelete("CASCADE");
            $table->foreign("currency_id")->on("currencies")->references("id")->onDelete("CASCADE");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currency_gateway');
    }
}
