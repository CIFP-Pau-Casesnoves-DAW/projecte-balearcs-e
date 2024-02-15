<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Espais;
use App\Models\Fotos;
use App\Models\Audios;

class PuntsInteres extends Model
{
    use HasFactory;

    protected $table = 'punts_interes';
    protected $primaryKey = 'id';

    protected $fillable = [
        'titol',
        'descripcio',
        'espai_id',
    ];

    public function espai()
    {
        return $this->belongsTo(Espais::class, 'espai_id', 'id');
    }

    protected $with = ['fotos', 'audios'];

    public function fotos()
    {
        return $this->hasMany(Fotos::class, 'punt_interes_id', 'id');
    }

    public function audios()
    {
        return $this->hasMany(Audios::class, 'punt_interes_id', 'id');
    }
}
