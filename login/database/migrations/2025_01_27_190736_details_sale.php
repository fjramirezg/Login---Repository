<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('details_sale', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('venta_id');
            $table->unsignedBigInteger('producto_id');
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('descuento', 10, 2)->default(0.00);
            $table->decimal('subtotal', 10, 2);
            $table->decimal('impuestos', 10, 2)->default(0.00);
            $table->decimal('total', 10, 2);
            $table->dateTime('fecha_venta')->useCurrent();
            $table->timestamps();

            // FK hacia sales con ON DELETE CASCADE
            $table->foreign('venta_id')
                ->references('id')
                ->on('sales')
                ->cascadeOnDelete();

            // FK hacia products con ON DELETE RESTRICT
            $table->foreign('producto_id')
                ->references('id')
                ->on('products')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('details_sale');
    }
};
