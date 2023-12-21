<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Valoracions extends Model
{
    use HasFactory;

    protected $table = 'valoracions';

    protected $fillable = [
        'puntuacio',
        'data',
        'data_baixa',
        'usuari_id',
        'espai_id',
    ];

    protected $dates = [
        'data',
        'data_baixa',
    ];

    public function usuari()
    {
        return $this->belongsTo(Usuari::class, 'usuari_id');
    }

    public function espai()
    {
        return $this->belongsTo(Espais::class, 'espai_id');
    }
}