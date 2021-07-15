<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('views', function (Blueprint $table) {
            $table->id() ;
            $table->unsignedBigInteger("viewable_id") ;
            $table->string("viewable_type") ;
            $table->unsignedBigInteger("user_id")->index()->nullable() ;
            $table->ipAddress("user_ip") ;
            $table->boolean("marked")->default(false);
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
        Schema::dropIfExists('views');
    }
}
