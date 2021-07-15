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
            $table->id() ;
            $table->unsignedBigInteger("user_id")->index() ;
            $table->enum('format' , EnumsFile::type() ) ;
            $table->string("type");
            $table->text("image_name") ;
            $table->text("base_path") ;
            $table->string('thumb_dir')->nullable() ;
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('files');
    }
}
