<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitesPuntsInteres extends Model
{
    use HasFactory;

    protected $table = 'visites_punts_interes';
    protected $primaryKey = ['punts_interes_id', 'visita_id'];
    public $incrementing = false;

    protected $fillable = [
        'punt_interes_id',
        'visita_id',
        'ordre',
    ];

    public function puntInteres()
    {
        return $this->belongsTo(PuntsInteres::class, 'punts_interes_id');
    }

    public function visita()
    {
        return $this->belongsTo(Visites::class, 'visita_id');
    }
}
