<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idiomes extends Model
{
    use HasFactory;

    protected $table = 'idiomes';
    protected $primaryKey = 'id';

    protected $fillable = [
        'idioma',
        'data_baixa'
    ];

    // Relacions amb altres models, si n'hi ha
    // Per exemple, si un idioma està associat amb traduccions específiques

    /**
     * Relació amb el model EspaiIdioma.
     */
    public function espaisIdiomes()
    {
        return $this->hasMany(EspaisIdiomes::class, 'idioma_id');
    }

    /**
     * Relació amb el model ServeiIdioma.
     */
    public function serveisIdiomes()
    {
        return $this->hasMany(ServeisIdiomes::class, 'idioma_id');
    }

    /**
     * Relació amb el model VisitesIdiomes.
     */
    public function visitesIdiomes()
    {
        return $this->hasMany(VisitesIdiomes::class, 'idioma_id');
    }

    /**
     * Relació amb el model ModalitatsIdiomes.
     */
    public function modalitatsIdiomes()
    {
        return $this->hasMany(ModalitatsIdiomes::class, 'idioma_id');
    }
}