<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('account_id');
            $table->unsignedInteger('unit_id');
            $table->unsignedInteger('brand_id');
            $table->unsignedInteger('vendor_id');
            $table->string('name');
            $table->text('description');

            $table->foreign('account_id')
                  ->references('id')
                  ->on('accounts');

            $table->foreign('unit_id')
                  ->references('id')
                  ->on('units');

            $table->foreign('brand_id')
                  ->references('id')
                  ->on('brands');

            $table->foreign('vendor_id')
                  ->references('id')
                  ->on('vendors');

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
        Schema::dropIfExists('products');
    }
}
