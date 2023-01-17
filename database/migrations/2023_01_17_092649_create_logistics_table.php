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
        Schema::create('logistics', function (Blueprint $table) {
            $table->id();
            $table->string('logistic_category_code')->nullable();
            $table->string('nama_barang');
            $table->integer('stock_logistic')->default(0);
            $table->string('satuan')->nullable();
            $table->text('keterangan')->nullable();
            $table->boolean('status_logistic')->default(1)->comment('1: aktif, 0: nonaktif');
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
        Schema::dropIfExists('logistics');
    }
};
