<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audios extends Model
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
        return $this->belongsTo(PuntInteres::class, 'punt_interes_id');
    }

    
}
