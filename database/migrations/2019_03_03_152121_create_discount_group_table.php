<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_group', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('discount_id');
            $table->unsignedInteger('group_id');

            $table->foreign('discount_id')
                  ->references('id')
                  ->on('discounts');

            $table->foreign('group_id')
                  ->references('id')
                  ->on('groups');

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
        Schema::dropIfExists('discount_groups');
    }
}
