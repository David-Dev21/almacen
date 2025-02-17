<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleIngreso extends Model
{
    use HasFactory;

    protected $table = 'detalle_ingresos';

    protected $fillable = ['lote', 'cantidad_original', 'cantidad_disponible', 'costo_u', 'id_ingreso', 'id_producto'];

    public function ingreso()
    {
        return $this->belongsTo(Ingreso::class, 'id_ingreso');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
