<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Idiomes;
use App\Models\Modalitats;

class ModalitatsIdiomes extends Model
{
    use HasFactory;

    protected $table = 'modalitats_idiomes';
    protected $primaryKey = ['idioma_id', 'modalitat_id'];
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'idioma_id',
        'modalitat_id',
        'traduccio',
        'data_baixa',
    ];

    public function idioma()
    {
        return $this->belongsTo(Idiomes::class);
    }

    public function modalitat()
    {
        return $this->belongsTo(Modalitats::class);
    }
}