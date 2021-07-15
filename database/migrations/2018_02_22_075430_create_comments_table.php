<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{

    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id() ;
            $table->unsignedBigInteger("comment_id")->index()->nullable() ;
            $table->unsignedBigInteger("post_id")->index() ;
            $table->unsignedBigInteger("user_id")->index()->nullable() ;
            $table->boolean("status")->default(false) ;
            $table->string("fullname")->nullable() ;
            $table->text('email')->nullable() ;
            $table->text('website')->nullable() ;
            $table->ipAddress("ipv4")->nullable() ;
            $table->text("content") ;
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
