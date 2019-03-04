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
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('account_id');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('image_id')->nullable();

            $table->foreign('account_id')
                  ->references('id')
                  ->on('accounts');

            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories');

            $table->foreign('image_id')
                  ->references('id')
                  ->on('images');

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
