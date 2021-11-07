<?php

use App\Core\Enums\EnumsFileable;
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

            $table->increments("id") ;

            $table->uuid('file_id')->index();
            $table->morphs("fileable");
            $table->enum("usage", EnumsFileable::usages());

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
        Schema::dropIfExists('fileables');
    }
}
