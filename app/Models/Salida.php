<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salida extends Model
{
    use HasFactory;
    protected $table = 'salidas';
    protected $primaryKey = 'id_salida';

    protected $fillable = ['n_hoja_ruta', 'n_pedido', 'fecha_hora', 'total', 'estado', 'id_unidad', 'id_usuario'];

    public function unidad()
    {
        return $this->belongsTo(Unidad::class, 'id_unidad');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function detalleSalida()
    {
        return $this->hasMany(DetalleSalida::class, 'id_salida');
    }
}
