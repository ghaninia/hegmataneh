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
