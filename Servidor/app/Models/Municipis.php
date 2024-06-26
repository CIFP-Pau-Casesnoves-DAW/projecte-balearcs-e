<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Espais;

class Municipis extends Model
{
    use HasFactory;
    protected $table = 'municipis';
    protected $primaryKey = 'id';
    /**
     * Atributos que pueden ser asignados en masa.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'illa_id',
        'data_baixa',
    ];

    public function illa()
    {
        return $this->belongsTo(Illes::class, 'illa_id');
    }

    protected $with = ['espais'];

    public function espais()
    {
        return $this->hasMany(Espais::class, 'municipi_id', 'id');
    }
}
