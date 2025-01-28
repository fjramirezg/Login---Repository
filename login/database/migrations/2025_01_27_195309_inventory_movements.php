<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up():void
    {
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('producto_id');
            $table->string('tipo_movimiento', 50);
            $table->integer('cantidad');
            $table->dateTime('fecha')->useCurrent();
            $table->timestamps();

            // FK hacia products con ON DELETE RESTRICT
            $table->foreign('producto_id')
                ->references('id')
                ->on('products')
                ->restrictOnDelete();
        });
    }

    public function down():void
    {
        Schema::dropIfExists('inventory_movements');
    }
};
