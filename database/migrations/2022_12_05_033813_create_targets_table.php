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
        Schema::create('targets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('periode');
            $table->integer('target');
            $table->integer('total')->nullable();
            $table->string('persen')->nullable();
            $table->boolean('status')->default(0)->comment('0: tidak tercapai, 1: tercapai');
            $table->boolean('type')->default(1)->comment('0: tidak aktif, 1: aktif');
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
        Schema::dropIfExists('targets');
    }
};
