<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class EspaisModalitats extends Pivot
{
    use HasFactory;

    protected $table = 'espais_modalitats';

    public $incrementing = false;
    protected $primaryKey = ['espai_id', 'modalitat_id'];


    protected $fillable = [
        'espai_id',
        'modalitat_id',
        'data_baixa'
    ];

    /**
     * Relació amb el model Espai.
     */
    public function espai()
    {
        return $this->belongsTo(Espai::class, 'espai_id');
    }

    /**
     * Relació amb el model Modalitat.
     */
    public function modalitat()
    {
        return $this->belongsTo(Modalitat::class, 'modalitat_id');
    }


    /**
     * Obté la clau primària per al model.
     *
     * @return mixed
     */
    public function getKey()
    {
        // Retorna un array amb els valors de les claus primàries
        return [$this->espai_id, $this->modalitat_id];
    }

    /**
     * Obté el nom de la clau primària per al model.
     *
     * @return string
     */
    public function getKeyName()
    {
        // Retorna un array amb els noms de les claus primàries
        return ['espai_id', 'modalitat_id'];
    }

    /**
     * Estableix la clau primària per a la consulta d'emmagatzematge del model.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function setKeysForSaveQuery($query)
    {
        $query->where('espai_id', $this->getAttribute('espai_id'))
              ->where('modalitat_id', $this->getAttribute('modalitat_id'));
        return $query;
    }
}

