<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBasketablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('basketables', function (Blueprint $table) {
            $table->uuid("id");
            $table->foreignId("basket_id")
                ->constrained("baskets")
                ->onDelete("CASCADE")
                ->onUpdate("CASCADE") ;
            $table->morphs("basketable");
            $table->integer("unit")->default(0) ;
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
        Schema::dropIfExists('basketables');
    }
}
