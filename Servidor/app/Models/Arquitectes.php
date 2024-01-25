<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arquitectes extends Model
{
    use HasFactory;

    // Nom de la taula en la base de dades
    protected $table = 'arquitectes';


    /**
     * Atributs que poden ser assignats en massa.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'data_baixa'
    ];

    public function espais()
    {
        return $this->hasMany(Espais::class);
    }
}

