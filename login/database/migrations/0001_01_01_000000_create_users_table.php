<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 50)->unique();
            $table->string('first_name', 50)->nullable();
            $table->string('last_name', 50)->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('profile_image', 255)->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->timestamp('last_login')->nullable();
        });
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'first_name',
                'last_name',
                'phone_number',
                'date_of_birth',
                'profile_image',
                'status',
                'last_login',
            ]);
        });
    }
}
