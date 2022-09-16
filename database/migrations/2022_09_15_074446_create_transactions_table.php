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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('member_id')->nullable();
            $table->string('nomor_pesanan');
            $table->date('tanggal_transaksi');
            $table->string('image')->nullable();
            $table->string('expedisi')->nullable();
            $table->integer('ongkir')->nullable();
            $table->char('origin_customer')->comment('0: ads adv, 1: marketplace, 2: reepet order');
            $table->boolean('type_transaction')->comment('0: cod, 1: transfer');
            $table->char('type_customer')->comment('0: reseller, 1: agen, 2: end user');
            $table->text('catatan')->nullable();
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
        Schema::dropIfExists('transactions');
    }
};
