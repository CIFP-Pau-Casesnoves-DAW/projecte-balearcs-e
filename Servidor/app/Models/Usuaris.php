<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuaris extends Model
{
    use HasFactory;
    protected $table = 'usuaris';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = false;
    /**
     * Atributos que pueden ser asignados en masa.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'llinatges',
        'dni',
        'mail',
        'contrasenya',
        'rol',
        'data_baixa',
        'api_token',
    ];
}
