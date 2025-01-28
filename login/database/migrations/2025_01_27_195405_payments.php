<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up():void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('venta_id');
            $table->decimal('monto', 10, 2);
            $table->string('metodo_pago', 50);
            $table->dateTime('fecha')->useCurrent();
            $table->timestamps();

            // FK hacia sales con ON DELETE CASCADE
            $table->foreign('venta_id')
                ->references('id')
                ->on('sales')
                ->cascadeOnDelete();
        });
    }

    public function down():void
    {
        Schema::dropIfExists('payments');
    }
};
