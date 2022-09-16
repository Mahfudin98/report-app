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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('member_name');
            $table->string('member_phone');
            $table->string('member_alamat');
            $table->string('district_id');
            $table->date('join_on')->nullable();
            $table->string('image')->nullable();
            $table->boolean('member_type')->comment('0: reseller, 1:agen');
            $table->boolean('member_status')->default(true)->comment('0: tidak aktif, 1: aktif');
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
        Schema::dropIfExists('members');
    }
};
