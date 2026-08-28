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
        Schema::create('sys_menu_permissions', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->uuid('public_id');
            $table->integer('id_menu');
            $table->integer('id_roles');
            $table->char('view', 2)->default(0);
            $table->char('add', 2)->default(0);
            $table->char('edit', 2)->default(0);
            $table->char('delete', 2)->default(0);
            $table->char('report', 2)->default(0);
            $table->char('password', 2)->default(0);
            $table->char('agree', 2)->default(0);
            $table->char('back', 2)->default(0);
            $table->char('config', 2)->default(0);
            $table->char('module', 2)->default(0);
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
        Schema::dropIfExists('sys_menu_permissions');
    }
};
