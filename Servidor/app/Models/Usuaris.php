<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuaris extends Model
{
    use HasFactory;
    protected $table = 'usuaris';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;
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
    ];
}
