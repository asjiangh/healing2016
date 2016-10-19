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
//            $table->string('cid',80);
            $table->string('openid', 28)->index();
            $table->tinyInteger('school_id')->index();
//            $table->string('client',20);
//            $table->index(['cid', 'client']);
            $table->string('nickname', 80);
            $table->tinyInteger('sex'); // 0 => female, 1 => male.
//            $table->string('pictures',255);
            $table->string('avatar');     //默认获取为headimgurl
            $table->string('phone', 20);
//            $table->dateTime('register_time')->index();
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
        Schema::dropIfExists('users');
    }
}
