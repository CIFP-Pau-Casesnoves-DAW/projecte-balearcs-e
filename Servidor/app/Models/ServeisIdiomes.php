<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServeisIdiomes extends Model
{
    use HasFactory;

    protected $table = 'serveis_idiomes';

    protected $fillable = [
        'idioma_id',
        'servei_id',
        'traduccio',
        'data_baixa',
    ];

    protected $primaryKey = ['idioma_id', 'servei_id'];
    public $incrementing = false;

    protected $dates = [
        'data_baixa',
    ];

    public function idioma()
    {
        return $this->belongsTo(Idiomes::class, 'idioma_id');
    }

    public function servei()
    {
        return $this->belongsTo(Serveis::class, 'servei_id');
    }
}