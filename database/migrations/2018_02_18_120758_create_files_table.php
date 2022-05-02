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
            $table->foreignId("user_id")->nullable()->constrained("users")->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum("type", EnumsFile::type())->default(EnumsFile::TYPE_FILE);
            $table->string("driver");
            $table->text("name");
            $table->text("path");
            $table->text("extension")->nullable();
            $table->text("mime_type")->nullable();
            $table->integer("size")->nullable();
            $table->timestamps();
        });

        Schema::table("files" , function (Blueprint $table){
            $table->foreignUuid("folder_id")->nullable()->constrained("files")->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    public function down()
    {
        Schema::dropIfExists('files');
    }
}
