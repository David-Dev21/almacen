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
        Schema::create('salidas', function (Blueprint $table) {
            $table->increments('id_salida');
            $table->string('n_hoja_ruta', 30)->notNullable();
            $table->string('n_pedido', 30)->notNullable();
            $table->timestamp('fecha_hora')->notNullable();
            $table->decimal('total', 10, 2)->check('total >= 0')->notNullable();
            $table->enum('estado', ['completado', 'cancelado', 'pendiente'])->notNullable();
            $table->unsignedInteger('id_unidad');
            $table->unsignedInteger('id_usuario');
            $table->timestamps();
            $table->foreign('id_unidad')->references('id_unidad')
                ->on('unidades')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('id_usuario')->references('id')
                ->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->unique(['n_hoja_ruta', 'n_pedido', 'id_unidad']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salidas');
    }
};
