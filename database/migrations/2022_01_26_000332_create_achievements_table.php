<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAchievementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('achievements');

        Schema::create('achievements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100);
            $table->string('description');
            $table->unsignedSmallInteger('points')->default(1);
            $table->string('class_name');
            $table->enum('type', ['comment_written', 'lesson_watched','badge'])->nullable();
            // $table->unsignedInteger('next_achievement_id')->nullable();
            $table->timestamps();
        });

        // Schema::table('achievements',function (Blueprint $table){
            // $table->foreign('next_achievement_id')->references('id')->on('achievements');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('achievements');
    }
}
