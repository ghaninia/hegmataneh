<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationsTable extends Migration
{

    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id() ;
            $table->unsignedBigInteger("file_id")->index() ;
            $table->boolean("pin")->default(false) ;
            $table->string("fullname") ;
            $table->string("career") ;
            $table->text("text") ;
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quotations');
    }

}
