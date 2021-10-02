<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikesTable extends Migration
{

    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id() ;
            $table->unsignedBigInteger("likeable_id") ;
            $table->string("likeable_type") ;
            $table->unsignedBigInteger("user_id")->nullable()->index() ;
            $table->ipAddress("ipv4")->nullable() ;
            $table->boolean("like")->default(false) ;
            $table->boolean("unlike")->default(false) ;
            $table->timestamps() ;
        });
    }

    public function down()
    {
        Schema::dropIfExists('likes');
    }
}
