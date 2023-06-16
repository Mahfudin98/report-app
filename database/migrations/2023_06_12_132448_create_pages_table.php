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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('page_id')->unique();
            $table->unsignedBigInteger('member_id');
            $table->string('product_code')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('harga_jual')->nullable();
            $table->integer('harga_discount')->nullable();
            $table->boolean('type')->comment('0: landing page, 1: linktree');
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('pages');
    }
};