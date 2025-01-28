<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up():void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('vendedor_id');
            $table->decimal('total', 10, 2)->default(0.00);
            $table->boolean('aprobada')->default(false);
            $table->timestamps();

            // FK a clientes con ON DELETE RESTRICT
            $table->foreign('cliente_id')
                ->references('id')
                ->on('clientes')
                ->restrictOnDelete();

            // FK a users con ON DELETE RESTRICT (vendedor_id)
            $table->foreign('vendedor_id')
                ->references('id')
                ->on('users')
                ->restrictOnDelete();
        });
    }

    public function down():void
    {
        Schema::dropIfExists('sales');
    }
};
