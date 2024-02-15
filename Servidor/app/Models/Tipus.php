<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Espais;

class Tipus extends Model
{
    use HasFactory;

    protected $table = 'tipus';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nom_tipus',
        'data_baixa',
    ];

    protected $with = ['espais'];

    public function espais()
    {
        return $this->hasMany(Espais::class, 'tipus_id', 'id');
    }
}
