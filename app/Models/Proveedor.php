<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    protected $table = 'proveedores';
    protected $primaryKey = 'id_proveedor';

    protected $fillable = ['razon_social', 'nombre', 'nit', 'direccion', 'telefono', 'estado'];

    public function setRazonSocialAttribute($value)
    {
        $this->attributes['razon_social'] = strtoupper($value);
    }
    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = strtoupper($value);
    }
    public function setDireccionAttribute($value)
    {
        $this->attributes['direccion'] = strtoupper($value);
    }

    public function ingresos()
    {
        return $this->hasMany(Ingreso::class, 'id_proveedor');
    }
}
