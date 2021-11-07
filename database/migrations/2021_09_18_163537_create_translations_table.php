<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->id();

            $table->foreignId("language_id")
                ->references("id")
                ->on("languages")
                ->onDelete("CASCADE")
                ->onUpdate("CASCADE");

            $table->morphs("translationable");

            $table->string("field");

            $table->longText('trans');
        });

        // DB::statement('ALTER TABLE `translations` ADD FULLTEXT INDEX translation_trans_index (trans)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('translations', function ($table) {
        //     $table->dropIndex('translation_trans_index');
        // });
        Schema::dropIfExists('translations');
    }
}
