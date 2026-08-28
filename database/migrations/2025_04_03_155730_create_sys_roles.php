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
        Schema::create('sys_roles', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->uuid('public_id');
            $table->string('nama')->nullable();
            $table->longText('keterangan')->nullable();
            $table->char('is_trash', 2)->nullable();
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
        Schema::dropIfExists('sys_roles');
    }
};
