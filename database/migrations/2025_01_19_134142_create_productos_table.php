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
        Schema::create('productos', function (Blueprint $table) {
            $table->increments('id_producto');
            $table->string('codigo', 50)->unique()->notNullable();
            $table->string('descripcion', 255)->notNullable();
            $table->integer('stock')->default(0)->check('stock >= 0')->notNullable();
            $table->string('unidad', 20)->notNullable();
            $table->string('imagen', 20)->nullable();
            $table->tinyInteger('estado')->default(1)->check('estado IN (0, 1)')->notNullable();
            $table->unsignedInteger('id_categoria');
            $table->timestamps();
            $table->foreign('id_categoria')->references('id_categoria')
                ->on('categorias')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
