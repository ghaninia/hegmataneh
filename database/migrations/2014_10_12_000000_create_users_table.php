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
            $table->id();

            $table->unsignedBigInteger("currency_id")->nullable();
            $table->unsignedBigInteger("language_id")->nullable();
            $table->unsignedBigInteger("role_id");

            $table->string("name")->nullable();
            $table->boolean("status")->default(false);
            $table->string("username", 100)->unique()->nullable();
            $table->string('email')->unique();
            $table->string('mobile')->unique()->nullable();
            $table->text('bio')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->timestamp("verified_at")->nullable();
            $table->softDeletes();

            $table->index("language_id");
            $table->index("currency_id");
            $table->index("username");
            $table->index("mobile");
            $table->index("email");

            $table->foreign("currency_id")
                ->references("id")
                ->on("currencies")
                ->onDelete("SET NULL")
                ->onUpdate("SET NULL");

            $table->foreign("language_id")
                ->references("id")
                ->on("languages")
                ->onDelete("SET NULL")
                ->onUpdate("SET NULL");

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
