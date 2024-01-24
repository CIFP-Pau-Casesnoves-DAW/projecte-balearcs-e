<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serveis extends Model
{
    use HasFactory;

    protected $table = 'serveis';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nom_serveis',
        'data_baixa',
    ];
}
