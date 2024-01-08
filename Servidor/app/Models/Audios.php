<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
    use HasFactory;

    protected $table = 'audios';
    

    protected $fillable = [
        'url',
        'punt_interes_id',
        'data_baixa'
    ];

    /**
     * Relació amb el model PuntInteres.
     */
    public function puntInteres()
    {
        return $this->belongsTo(PuntsInteres::class, 'punt_interes_id');
    }

    
}
