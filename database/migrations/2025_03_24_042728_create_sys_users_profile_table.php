<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sys_users_profile', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->uuid('public_id')->nullable();
            $table->integer('id_user');
            $table->char('id_provinsi', 3)->nullable();
            $table->char('id_kabupaten', 5)->nullable();
            $table->char('id_kecamatan', 7)->nullable();
            $table->string('nama')->nullable();
            $table->date('tgl')->nullable();
            $table->char('tlp', 14)->nullable();
            $table->longText('alamat')->nullable();
            $table->longText('photo')->nullable();
            $table->integer('created')->nullable();
            $table->dateTime('created_date', $precision = 0)->nullable();
            $table->integer('updated')->nullable();
            $table->dateTime('updated_date', $precision = 0)->nullable();
            $table->integer('deleted')->nullable();
            $table->dateTime('deleted_date', $precision = 0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sys_users_profile');
    }
};
