<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('songs',function(Blueprint $table){
            $table->increments('id');
            $table->string('name',80)->index();
            $table->integer('uid')->index();
            $table->boolean('done');
            $table->boolean('deleted');
            $table->index(['done', 'deleted']);
            $table->integer('dial_number')->index();
            $table->dateTime('create_time')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('songs');
    }
}
