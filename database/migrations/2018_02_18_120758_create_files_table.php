<?php

use App\Kernel\Enums\EnumsFile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{

    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->uuid("file_id")->index()->nullable();
            $table->unsignedBigInteger("user_id")->index();
            $table->enum("type", EnumsFile::type());
            $table->string("name");
            $table->string("extension")->nullable();
            $table->string("mime_type")->nullable();
            $table->integer("size")->default(0);
            $table->timestamps();
        });

        Schema::table('files', function (Blueprint $table) {
            $table->foreign("file_id")->references("id")->on("files")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    public function down()
    {
        Schema::dropIfExists('files');
    }
}
