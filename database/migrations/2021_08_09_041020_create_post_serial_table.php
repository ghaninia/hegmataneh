<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->unsignedBigInteger("post_id");
            $table->unsignedBigInteger("serial_id");
            $table->string("title");
            $table->boolean("is_locked")->default(TRUE);
            $table->tinyInteger("priority")->nullable();
            $table->longText("description")->nullable();

            $table->foreign("post_id")
                ->references("id")
                ->on("posts")
                ->onDelete("CASCADE")
                ->onUpdate("CASCADE");

            $table->foreign("serial_id")
                ->references("id")
                ->on("serials")
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
        Schema::dropIfExists('post_serial');
    }
}
