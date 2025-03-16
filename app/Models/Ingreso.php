<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    use HasFactory;

    protected $table = 'ingresos';
    protected $primaryKey = 'id_ingreso';

    protected $fillable = ['n_factura', 'n_pedido', 'fecha_hora', 'total', 'id_proveedor', 'id_usuario'];


    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function detalleIngresos()
    {
        return $this->hasMany(DetalleIngreso::class, 'id_ingreso');
    }
}
