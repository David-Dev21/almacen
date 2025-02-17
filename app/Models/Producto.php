<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'productos';
    protected $primaryKey = 'id_producto';

    protected $fillable = ['codigo', 'descripcion', 'stock', 'unidad', 'imagen', 'estado', 'id_categoria'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    public function detalleIngresos()
    {
        return $this->hasMany(DetalleIngreso::class, 'id_producto');
    }
    public function detalleSalidas()
    {
        return $this->hasMany(DetalleSalida::class, 'id_producto');
    }
}
