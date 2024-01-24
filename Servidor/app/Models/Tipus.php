<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipus extends Model
{
    use HasFactory;

    protected $table = 'tipus';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nom_tipus',
        'data_baixa',
    ];
}