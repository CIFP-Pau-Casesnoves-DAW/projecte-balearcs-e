<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Municipis;

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

    protected $with = ['municipis'];

    public function municipis()
    {
        return $this->hasMany(Municipis::class, 'illa_id', 'id');
    }
}
