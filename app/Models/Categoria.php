<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    protected $table = 'categorias';
    protected $primaryKey = 'id_categoria';

    protected $fillable = ['codigo', 'descripcion', 'estado'];

    public $timestamps = true; // Ensure timestamps are enabled

    public function productos()
    {
        return $this->hasMany(Producto::class, 'id_categoria');
    }
}
