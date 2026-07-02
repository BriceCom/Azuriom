<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spin_laps', function (Blueprint $table) {
            Schema::dropIfExists('spin_laps');

            $table->increments('id');
            $table->integer('user_id');
            $table->integer('reward_id');
            $table->text('reward_name');
            $table->float('spin_price');
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
        Schema::dropIfExists('spin_laps');
    }
};
