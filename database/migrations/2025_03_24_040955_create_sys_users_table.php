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
        Schema::create('sys_users', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->uuid('public_id')->nullable();
            $table->integer('id_roles')->nullable();
            $table->string('username')->nullable();
            $table->longText('password')->nullable();
            $table->longText('remember_token')->nullable();
            $table->char('is_verifikasi', 2)->default(0);
            $table->longText('mails')->nullable();
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
        Schema::dropIfExists('sys_users');
    }
};
