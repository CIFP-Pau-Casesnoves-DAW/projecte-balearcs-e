<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Illes extends Model
{
    use HasFactory;
    protected $table = 'illes';
    protected $primaryKey = 'id';
    /**
     * Atributos que pueden ser asignados en masa.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'zona',
        'data_baixa',
    ];
}
