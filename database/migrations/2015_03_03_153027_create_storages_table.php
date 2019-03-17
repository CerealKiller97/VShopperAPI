<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('address');
            $table->integer('size');
            $table->unsignedInteger('storage_type_id');
            $table->unsignedInteger('account_id');


            $table->foreign('storage_type_id')
                  ->references('id')
                  ->on('storage_types');

            $table->foreign('account_id')
                  ->references('id')
                  ->on('accounts');

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
        Schema::dropIfExists('storages');
    }
}
