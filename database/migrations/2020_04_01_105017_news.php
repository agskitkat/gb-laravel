<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class News extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Категории
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('Название категории');
            $table->string('alias')->unique()->comment('Адрес категории');
            $table->bigInteger('parent_id')->nullable()->comment('Родительская категория');
            $table->timestamps();
        });

        // Новости
        Schema::create('news', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('Название новости');
            $table->string('alias')->unique()->comment('Алиас новости');
            $table->text('text')->comment('Текст новости');
            $table->timestamps();
        });

        // Связь новостей с категориями
        Schema::create('category_news', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('category_id')
                ->unsigned()
                ->comment('Категория');

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');

            $table->bigInteger('news_id')
                ->unsigned()
                ->comment('Новость');

            $table->foreign('news_id')
                ->references('id')
                ->on('news')
                ->onDelete('cascade');

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
        Schema::dropIfExists('category_news');
        Schema::dropIfExists('news');
        Schema::dropIfExists('categories');
    }
}
