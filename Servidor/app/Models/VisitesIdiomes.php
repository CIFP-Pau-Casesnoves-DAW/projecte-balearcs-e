<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitesIdiomes extends Model
{
    use HasFactory;

    protected $table = 'visites_idiomes';

    protected $fillable = [
        'idioma_id',
        'visita_id',
        'traduccio',
        'data_baixa',
    ];

    protected $primaryKey = ['idioma_id', 'visita_id'];
    public $incrementing = false;

    protected $dates = [
        'data_baixa',
    ];

    public function idioma()
    {
        return $this->belongsTo(Idiomes::class, 'idioma_id');
    }

    public function visita()
    {
        return $this->belongsTo(Visita::class, 'visita_id');
    }
}
