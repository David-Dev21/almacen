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
        Schema::create('proveedores', function (Blueprint $table) {
            $table->increments('id_proveedor');
            $table->string('razon_social', 30)->nullable();
            $table->string('nombre', 30)->notNull();
            $table->string('nit', 30)->unique()->nullable();
            $table->string('direccion', 100)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->tinyInteger('estado')->default(1)->check('estado IN (0, 1)')->notNullable();
            $table->string('email', 30)->unique()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedores');
    }
};
