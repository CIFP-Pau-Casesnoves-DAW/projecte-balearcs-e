<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Illa extends Model
{
    use HasFactory;
    protected $table = 'illes';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = false;
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
