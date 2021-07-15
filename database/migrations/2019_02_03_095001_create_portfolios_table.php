<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortfoliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id() ;
            $table->unsignedBigInteger("user_id") ;
            $table->unsignedBigInteger("file_id")->nullable() ;
            $table->string("name") ;
            $table->text("description") ;
            $table->text("excerpt")->nullable() ;
            $table->integer("percent")->default(0) ;
            $table->text("demo")->nullable() ;
            $table->timestamp("started_at")->nullable() ;
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
        Schema::dropIfExists('portfolios');
    }
}
