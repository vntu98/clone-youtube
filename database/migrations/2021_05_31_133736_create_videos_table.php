<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('channel_id');
            $table->string('uid');
            $table->string('title');
            $table->string('description')->nullable();
            $table->boolean('processed')->default(false);
            $table->string('video_id')->nullable();
            $table->string('video_filename')->nullable();
            $table->enum('visibility', ['public', 'unlisted', 'private']);
            $table->boolean('allow_votes')->default(false);
            $table->boolean('allow_comments')->default(false);
            $table->integer('processed_percentage')->nullable();
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
        Schema::dropIfExists('videos');
    }
}
