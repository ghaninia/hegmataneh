<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostSerialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_serial', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("post_id") ;
            $table->unsignedBigInteger("serial_id") ;
            $table->string("title") ;
            $table->boolean("is_locked")->default(TRUE) ;
            $table->tinyInteger("priority") ;
            $table->longText("description") ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_serial');
    }
}
