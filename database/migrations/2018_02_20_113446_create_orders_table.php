<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id() ;
            $table->unsignedBigInteger("user_id")->index();
            $table->unsignedBigInteger("gateway_id")->index();
            $table->ipAddress("ipv4");
            $table->string("status")->nullable();
            $table->float("total_price", 20, 2);
            $table->float("total_discount", 20, 2);
            $table->float("total_final_price", 20, 2);
            $table->string("tracking_code")->nullable();
            $table->unsignedBigInteger("transaction_id")->nullable();
            $table->unsignedBigInteger('ref_id')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('orders');
    }
}
