<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageStorageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_storage', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('storage_id');
            $table->unsignedInteger('image_id');

            $table->foreign('storage_id')
                  ->references('id')
                  ->on('storages');

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
        Schema::dropIfExists('storage_images');
    }
}
