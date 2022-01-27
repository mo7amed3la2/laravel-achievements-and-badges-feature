<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBadgeProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('badge_progress', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('badge_id');
            $table->foreignId('user_id')->constrained();
            $table->unsignedSmallInteger('points')->default(0);
            $table->timestamp('unlocked_at')->nullable()->default(null);
            $table->timestamps();
            $table->foreign('badge_id')->references('id')->on('badges');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('badge_progress');
    }
}
