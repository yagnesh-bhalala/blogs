<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('visibility_status');
            $table->date('publish_date');
            $table->string('author_name');
            $table->string('meta_title');
            $table->string('meta_keyword');
            $table->string('meta_description');
            $table->string('slug');
            $table->unsignedTinyInteger('article_categories_id');
            $table->foreign('article_categories_id')->references('id')->on('article_categories');
            $table->unsignedTinyInteger('languages_id');
            $table->foreign('languages_id')->references('id')->on('languages');
            $table->text('image_path');
            $table->text('body_text');
            $table->unsignedInteger('created_by_user_id');
            $table->foreign('created_by_user_id')->references('id')->on('users');
            $table->unsignedInteger('updated_by_user_id')->nullable();
            $table->foreign('updated_by_user_id')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
};
