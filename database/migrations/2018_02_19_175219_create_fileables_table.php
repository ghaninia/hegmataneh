<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fileables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('file_id')->index();
            $table->string("fileables_id")->index();;
            $table->string("fileables_type");
            $table->string("usage")->nullable();
            $table->timestamps();

            $table->foreign("file_id")
                ->references("id")
                ->on("files")
                ->onDelete("CASCADE")
                ->onUpdate("CASCADE");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fileables');
    }
}
