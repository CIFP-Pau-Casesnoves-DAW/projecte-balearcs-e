<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PuntsInteres;
use App\Models\Espais;

class Audios extends Model
{
    use HasFactory;

    protected $table = 'audios';

    protected $fillable = [
        'audio',
        'punt_interes_id',
        'espai_id',
    ];

    /**
     * Relació amb el model PuntInteres.
     */
    public function puntInteres()
    {
        return $this->belongsTo(PuntsInteres::class, 'punt_interes_id');
    }

    public function espai()
    {
        return $this->belongsTo(Espais::class, 'espai_id');
    }
}
