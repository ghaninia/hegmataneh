<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_information', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger("post_id");

            $table->unsignedBigInteger("maximum_sell")->nullable();
            $table->unsignedBigInteger("expire_day")->nullable();
            $table->unsignedBigInteger("download_limit")->nullable();

            $table->float("price", 20, 2)->nullable()->default(0);
            $table->float("amazing_price", 20, 2)->nullable()->default(0);
            $table->timestamp("amazing_from_date")->nullable();
            $table->timestamp("amazing_to_date")->nullable();

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
        Schema::dropIfExists('product_information');
    }
}
