<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Usuaris;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Comentaris extends Model
{
    use HasFactory;
    protected $table = 'comentaris';
    protected $primaryKey = 'id';

    protected $fillable = [
        'comentari',
        'espai_id',
        'usuari_id',
        'data',
    ];

    /**
     * Relació amb el model Espai.
     */
    public function espai()
    {
        return $this->belongsTo(Espais::class, 'espai_id', 'id');
    }

    /**
     * Relació amb el model Usuari.
     */
    public function usuari()
    {
        return $this->belongsTo(Usuaris::class, 'usuari_id', 'id');
    }
}
