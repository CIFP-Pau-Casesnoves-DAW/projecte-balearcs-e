<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visites extends Model
{
    use HasFactory;

    protected $table = 'visites';

    protected $fillable = [
        'titol',
        'descripcio',
        'inscripcio_previa',
        'n_places',
        'total_visitants',
        'data_inici',
        'data_fi',
        'horari',
        'espai_id',
    ];

    public function espai()
    {
        return $this->belongsTo(Espais::class, 'espai_id');
    }
}