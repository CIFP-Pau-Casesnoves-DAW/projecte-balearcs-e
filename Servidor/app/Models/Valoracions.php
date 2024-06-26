<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Usuaris;
use App\Models\Espais;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function usuari()
    {
        return $this->belongsTo(Usuaris::class, 'usuari_id', 'id');
    }

    public function espai()
    {
        return $this->belongsTo(Espais::class, 'espai_id', 'id');
    }
}
