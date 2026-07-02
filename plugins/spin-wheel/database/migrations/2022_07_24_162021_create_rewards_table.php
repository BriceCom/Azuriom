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
        Schema::create('spin_rewards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->float('chances');
            $table->float('money')->default(0);
            $table->text('commands')->nullable();
            $table->boolean('need_online')->default(false);
            $table->boolean('is_enabled')->default(true);
            $table->text('color');
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
        Schema::dropIfExists('rewards');
    }
};
