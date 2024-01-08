<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class EspaisServeis extends Pivot
{
    use HasFactory;

    protected $table = 'espais_serveis';

    public $incrementing = true; // Si tens una clau primària autoincrementada
    protected $primaryKey = ['servei_id', 'espai_id']; // Defineix la clau primària composta

    protected $fillable = [
        'servei_id',
        'espai_id',
        'data_baixa'
    ];

    /**
     * Relació amb el model Servei.
     */
    public function servei()
    {
        return $this->belongsTo(Serveis::class, 'servei_id');
    }

    /**
     * Relació amb el model Espai.
     */
    public function espai()
    {
        return $this->belongsTo(Espai::class, 'espai_id');
    }

    
    /**
     * Obté la clau primària per al model.
     *
     * @return mixed
     */
    public function getKey()
    {
        // Retorna un array amb els valors de les claus primàries
        return [$this->servei_id, $this->espai_id];
    }

    /**
     * Obté el nom de la clau primària per al model.
     *
     * @return string
     */
    public function getKeyName()
    {
        // Retorna un array amb els noms de les claus primàries
        return ['servei_id', 'espai_id'];
    }

    /**
     * Estableix la clau primària per a la consulta d'emmagatzematge del model.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function setKeysForSaveQuery($query)
    {
        $query->where('servei_id', $this->getAttribute('servei_id'))
              ->where('espai_id', $this->getAttribute('espai_id'));
        return $query;
    }
}

