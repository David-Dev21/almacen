<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    use HasFactory;
    protected $table = 'unidades';
    protected $primaryKey = 'id_unidad';

    protected $fillable = ['jefe', 'nombre', 'direccion', 'telefono', 'estado'];

    public function setJefeAttribute($value)
    {
        $this->attributes['jefe'] = strtoupper($value);
    }
    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = strtoupper($value);
    }
    public function setDireccionAttribute($value)
    {
        $this->attributes['direccion'] = strtoupper($value);
    }
    public function salidas()
    {
        return $this->hasMany(Salida::class, 'id_unidad');
    }
}
