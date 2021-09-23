<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slugs', function (Blueprint $table) {
            
            $table->id();
            
            $table->morphs("slugable");
            
            $table->foreignId("language_id")
                ->constrained("languages")
                ->onDelete("CASCADE")
                ->onUpdate("CASCADE");

            $table->string("slug");
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slugs');
    }
}
