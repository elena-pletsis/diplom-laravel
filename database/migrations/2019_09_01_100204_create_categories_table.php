<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 64);
            $table->string('slug', 64);
            $table->string('img', 128)->nullable(); //может быть пустой, подставим заглушку

            $table->unsignedBigInteger('parent_id')->nullable();
            //https://laravel.com/docs/5.8/migrations
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('set null');

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
        Schema::dropIfExists('categories');
    }
}
