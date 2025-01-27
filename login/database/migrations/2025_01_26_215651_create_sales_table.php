<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('vendedor_id');
            $table->decimal('total', 10, 2)->default(0.00);
            $table->boolean('aprobada')->default(false);
            $table->timestamps(); // created_at, updated_at

            // Clave foránea a clientes (uno a muchos)
            $table->foreign('cliente_id')
                ->references('id')
                ->on('clientes')
                ->onDelete('restrict');

            // Clave foránea a users  (uno a muchos)
            $table->foreign('vendedor_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');

            //payments

            //details sale


        });
    }

    public function down()
    {
        Schema::dropIfExists('sales');
    }

};
