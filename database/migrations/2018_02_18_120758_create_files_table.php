<?php

use App\Core\Enums\EnumsFile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{

    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            
            $table->increments("id") ;

            $table->unsignedBigInteger("user_id")->index();
            $table->enum('type', EnumsFile::type());
            $table->text("path");
            $table->string("size");
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('files');
    }
}
