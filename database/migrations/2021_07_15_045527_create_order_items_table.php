<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("product_id")->unsigned()->index();
            $table->unsignedBigInteger("order_id")->unsigned()->index();
            $table->unsignedBigInteger("downloads_count")->default(0);
            $table->float("price", 20, 2);
            $table->string("token")->unique();
            $table->timestamp("expire_at")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
