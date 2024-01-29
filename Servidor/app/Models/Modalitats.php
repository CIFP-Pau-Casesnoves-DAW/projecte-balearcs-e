<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modalitats extends Model
{
    use HasFactory;

    protected $table = 'modalitats';

    protected $fillable = [
        'nom_modalitat',
        'data_baixa'
    ];

    /**
     * Relació amb el model EspaiModalitat.
     */
    public function espaisModalitats()
    {
        return $this->hasMany(EspaisModalitats::class, 'modalitat_id');
    }

    /**
     * Relació amb el model ModalitatsIdiomes.
     */
    public function modalitatsIdiomes()
    {
        return $this->hasMany(ModalitatsIdiomes::class, 'modalitat_id');
    }

}

