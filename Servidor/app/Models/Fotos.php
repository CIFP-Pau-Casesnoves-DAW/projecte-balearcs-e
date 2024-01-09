<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fotos extends Model
{
    use HasFactory;

    protected $table = 'fotos';

    protected $fillable = [
        'url',
        'punt_interes_id',
        'espai_id',
        'comentari',
        'data_baixa'
    ];

    /**
     * Relació amb el model PuntInteres.
     */
    public function puntInteres()
    {
        return $this->belongsTo(PuntsInteres::class, 'punt_interes_id');
    }

    /**
     * Relació amb el model Espai.
     */
    public function espai()
    {
        return $this->belongsTo(Espais::class, 'espai_id');
    }

}
