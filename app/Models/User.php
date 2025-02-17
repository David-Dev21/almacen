<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'ci',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

    public function getAuthIdentifier()
    {
        return $this->getKey(); // Esto asegura que devuelva la clave primaria (id)
    }

    public function ingresos()
    {
        return $this->hasMany(Ingreso::class, 'id');
    }
    public function salidas()
    {
        return $this->hasMany(Salida::class, 'id');
    }
}
