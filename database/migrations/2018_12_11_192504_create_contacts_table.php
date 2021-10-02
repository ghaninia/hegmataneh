<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id() ;
            $table->string("tracking_code" , 100 )->unique() ;
            $table->string("name") ;
            $table->string("email")->nullable();
            $table->string("phone")->nullable();
            $table->text('question') ;
            $table->ipAddress("ipv4") ;
            $table->text('user_agent') ;
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
        Schema::dropIfExists('contacts');
    }
}
