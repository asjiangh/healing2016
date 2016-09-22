<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cid',80);
            $table->string('client',20);
            $table->index(['cid', 'client']);
            $table->string('nickname',80)->unique();
            $table->tinyInteger('sex');
            $table->tinyInteger('school')->index();
            $table->string('pictures',255);
            $table->string('phone',40);
            $table->dateTime('register_time')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
