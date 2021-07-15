<?php

use App\Core\Enums\EnumsPost;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            $table->enum("type", EnumsPost::type());
            $table->enum("status", EnumsPost::status())->default(EnumsPost::STATUS_PUBLISHED);
            $table->unsignedBigInteger("user_id")->index();
            $table->unsignedBigInteger("file_id")->nullable()->index();

            //** post **//
            $table->enum('format', EnumsPost::type() )->nullable();

            $table->boolean("comment_status")->default(true);
            $table->boolean('vote_status')->default(true);
            $table->integer("development")->default(0);
            $table->text("title");
            $table->text('goal_post')->nullable();
            $table->string("slug")->unique();
            $table->text("content")->nullable();
            $table->text("excerpt")->nullable();
            $table->text("technology")->nullable();
            $table->string("theme")->nullable();

            //** product**//
            $table->unsignedBigInteger("maximum_sell")->nullable(); //حداکثر فروش
            $table->unsignedBigInteger("expire_day")->nullable(); // انقضا زمان بندی شده
            $table->unsignedBigInteger("download_limit")->nullable(); // محدودیت تعداد دانلود
            $table->text("attachment_id")->nullable();
            $table->string("price")->nullable()->default(0);
            $table->string("sale_price")->nullable(); //فروش فوق العاده
            $table->timestamp("sale_price_dates_from")->nullable(); //فروش فوقالعاده از زمان
            $table->timestamp("sale_price_dates_to")->nullable(); //فروش فوقالعاده تا زمان

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
