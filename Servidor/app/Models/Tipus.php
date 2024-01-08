<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipus extends Model
{
    use HasFactory;

    protected $table = 'tipus';

    protected $fillable = [
        'nom_tipus',
        'data_baixa',
    ];

    protected $dates = [
        'data_baixa',
    ];
}