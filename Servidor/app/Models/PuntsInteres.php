<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Espai;

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
        return $this->belongsTo(Espais::class, 'espai_id');
    }
}
