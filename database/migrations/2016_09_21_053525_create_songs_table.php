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
        Schema::create('songs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->string('name', 80)->index();
//            $table->integer('uid')->index();
//            $table->boolean('done');
//            $table->boolean('deleted');
//            $table->index(['done', 'deleted']);
            $table->integer('dialed_times');
//            $table->dateTime('create_time')->index();
            $table->json('meta');
            $table->timestamp('healed_at')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('songs');
    }
}
