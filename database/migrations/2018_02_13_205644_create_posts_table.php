<?php

use App\Kernel\Enums\EnumsPost;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id")->index();

            $table->enum("type", EnumsPost::type());
            $table->enum("status", EnumsPost::status())
                ->default(EnumsPost::STATUS_PUBLISHED);
            $table->enum('format', EnumsPost::format())->nullable();

            $table->boolean("comment_status")->default(true);
            $table->boolean('vote_status')->default(true);
            $table->integer("development")->default(0);

            // $table->string("slug")->unique()->nullable();
            // $table->text("title")->nullable() ;
            // $table->text("content")->nullable();
            // $table->text("excerpt")->nullable();
            // $table->text("faq")->nullable();
            // $table->text('goal_post')->nullable();

            $table->string("theme")->nullable();
            $table->timestamp("published_at")->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
