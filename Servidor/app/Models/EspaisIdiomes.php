<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class EspaisIdiomes extends Pivot
{
    use HasFactory;

    protected $table = 'espais_idiomes';
    public $incrementing = false;
    protected $primaryKey = ['idioma_id', 'espai_id']; 

    protected $fillable = [
        'idioma_id',
        'espai_id',
        'traduccio',
        'data_baixa'
    ];

    /**
     * Relació amb el model Espai.
     */
    public function espai()
    {
        return $this->belongsTo(Espais::class, 'espai_id');
    }

    /**
     * Relació amb el model Idioma.
     */
    public function idioma()
    {
        return $this->belongsTo(Idiomes::class, 'idioma_id');
    }

    // Recordau que hem de sobreescriure els mètodes `getKey` i `getKeyName` si utilitzam claus primàries compostes
    /**
     * Obté la clau primària per al model.
     *
     * @return mixed
     */
    public function getKey()
    {
        // Retorna un array amb els valors de les claus primàries
        return [$this->idioma_id, $this->espai_id];
    }

    /**
     * Obté el nom de la clau primària per al model.
     *
     * @return string
     */
    public function getKeyName()
    {
        // Retorna un array amb els noms de les claus primàries
        return ['idioma_id', 'espai_id'];
    }

    /**
     * Estableix la clau primària per el model.
     *
     * @param  mixed  $key
     * @return $this
     */
    public function setKeysForSaveQuery($query)
    {
        $query->where('idioma_id', $this->getAttribute('idioma_id'))
              ->where('espai_id', $this->getAttribute('espai_id'));
        return $query;
    }
}

