<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatAudioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_audio',function (Blueprint $table){
            $table->integer('id')->primary();
            $table->string('media_id',80)->index();
            $table->integer('listener_id')->index();
            $table->string('unique_id',40)->index();
            $table->dateTime('upload_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wechat_audio');
    }
}
