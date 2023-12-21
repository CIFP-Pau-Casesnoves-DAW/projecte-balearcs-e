<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Espai;

class PuntsInteres extends Model
{
    use HasFactory;

    protected $table = 'punts_interes';

    protected $fillable = [
        'titol',
        'descripcio',
        'data_baixa',
        'espai_id',
    ];

    protected $dates = [
        'data_baixa',
    ];

    public function espai()
    {
        return $this->belongsTo(Espai::class, 'espai_id');
    }
}
