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
        Schema::table('members', function (Blueprint $table) {
            $table->string('username')->unique()->nullable()->after('user_id');
            $table->string('password')->default('password')->after('username');
            $table->string('email')->unique()->nullable()->after('member_name');
            $table->string('province_id')->nullable()->after('member_alamat');
            $table->string('city_id')->nullable()->after('province_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->dropColumn('password');
            $table->dropColumn('email');
            $table->dropColumn('province_id');
            $table->dropColumn('city_id');
        });
    }
};
