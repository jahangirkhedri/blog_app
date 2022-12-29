<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::create('categories_posts', function (Blueprint $table) {
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('category_id');
            $table->foreign('post_id')->references('id')
                ->on('posts')
                ->onDelete('cascade');

            $table->foreign('category_id')->references('id')
                ->on('categories')
                ->onDelete('cascade');

            $table->unique(['post_id', 'category_id']);

        });
    }


    public function down()
    {
        Schema::dropIfExists('category_post');
    }
};
