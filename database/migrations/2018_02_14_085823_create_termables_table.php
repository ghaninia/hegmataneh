<?php

use App\Core\Enums\EnumsTerm;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('termables', function (Blueprint $table) {
            $table->id() ;
            $table->unsignedBigInteger("term_id")->index() ;
            $table->unsignedBigInteger("termables_id") ;
            $table->string("termables_type");
            $table->enum("type" , EnumsTerm::type() );
            $table->timestamps() ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('termables');
    }
}
