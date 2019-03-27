<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('address');
            $table->string('token')->default(bin2hex(random_bytes(60)));
            $table->timestamp('email_verified_at')->nullable()->default(null);
            $table->string('apiKey')->default(bin2hex(random_bytes(64)));
            $table->boolean('deactivated')->default(false);
            $table->unsignedInteger('image_id');

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
        Schema::dropIfExists('accounts');
    }
}
