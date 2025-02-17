<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleSalida extends Model
{
    use HasFactory;


    protected $table = 'detalle_salidas';

    // Define the fillable attributes
    protected $fillable = [
        'lote',
        'cantidad',
        'costo_u',
        'id_salida',
        'id_producto'
    ];

    public function salida()
    {
        return $this->belongsTo(Salida::class, 'id_salida');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
