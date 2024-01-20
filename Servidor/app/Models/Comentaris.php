<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentaris extends Model
{
    use HasFactory;
    protected $table = 'comentaris';

    public $incrementing = true; // Si tens una clau primària autoincrementada
    protected $primaryKey = 'id'; 

    protected $fillable = [
        'usuari_id',
        'espai_id',
        'data'
    ];

    /**
     * Relació amb el model Espai.
     */
    public function espai()
    {
        return $this->belongsTo(Espais::class, 'espai_id');
    }

    /**
     * Relació amb el model Idioma.
     */
    public function usuari()
    {
        return $this->belongsTo(Usuaris::class, 'usuari_id');
    }
}
