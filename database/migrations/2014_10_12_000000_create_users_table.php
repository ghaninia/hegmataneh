<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id() ;
            $table->string("name")->nullable();
            $table->unsignedBigInteger("role_id") ;
            $table->boolean("status")->default(false) ;
            $table->string("username" , 100)->unique()->nullable() ;
            $table->string('email')->unique();
            $table->string('mobile')->unique()->nullable();
            $table->text('bio')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes() ;

            $table->index([
                "username" ,
                "mobile" ,
                "email" ,
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
