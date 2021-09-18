<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->id();

            $table
                ->foreignId("currency_id")
                ->index()
                ->references("id")
                ->on("currencies")
                ->onDelete("CASCADE")
                ->onUpdate("CASCADE");

            $table->morphs("priceable");
            $table->float("price", 20, 2)->nullable()->default(0);

            $table->boolean("amazing_status")->default(FALSE);
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
        Schema::dropIfExists('prices');
    }
}
