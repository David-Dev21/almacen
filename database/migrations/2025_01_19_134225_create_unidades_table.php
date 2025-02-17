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
        Schema::create('unidades', function (Blueprint $table) {
            $table->increments('id_unidad');
            $table->string('jefe', 30)->nullable();
            $table->string('nombre', 50)->notNull();
            $table->string('direccion', 100)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->tinyInteger('estado')->default(1)->check('estado IN (0, 1)')->notNullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unidades');
    }
};
