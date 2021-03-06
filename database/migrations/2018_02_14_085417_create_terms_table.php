<?php

use App\Kernel\Enums\EnumsTerm;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terms', function (Blueprint $table) {
            $table->id() ;
            $table->unsignedBigInteger("term_id")->nullable()->index();
            $table->unsignedBigInteger("file_id")->nullable()->index() ;
            $table->enum("type" ,EnumsTerm::type())->default(EnumsTerm::TYPE_TAG) ;
            $table->string("color")->nullable();

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
        Schema::dropIfExists('terms');
    }
}
