<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Arquitectes;
use App\Models\Usuaris;
use App\Models\Tipus;
use App\Models\Municipis;
use App\Models\Comentaris;
use App\Models\Valoracions;
use App\Models\Visites;
use App\Models\PuntsInteres;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Espais extends Model
{
    use HasFactory;
    protected $table = 'espais';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nom',
        'descripcio',
        'carrer',
        'numero',
        'pis_porta',
        'web',
        'mail',
        'grau_acc',
        'any_cons',
        'arquitecte_id',
        'tipus_id',
        'municipi_id'
    ];

    /**
     * Relació amb el model Arquitecte.
     */
    public function arquitecte()
    {
        return $this->belongsTo(Arquitectes::class, 'arquitecte_id');
    }

    /**
     * Relació amb el model Usuaris (Gestor).
     */
    public function gestor()
    {
        return $this->belongsTo(Usuaris::class, 'gestor_id');
    }

    /**
     * Relació amb el model Tipus.
     */
    public function tipus()
    {
        return $this->belongsTo(Tipus::class, 'tipus_id');
    }

    /**
     * Relació amb el model Municipi.
     */
    public function municipi()
    {
        return $this->belongsTo(Municipis::class, 'municipi_id');
    }

    protected $with = ['comentaris', 'valoracions', 'visites', 'puntsinteres'];

    public function comentaris()
    {
        return $this->hasMany(Comentaris::class, 'espai_id', 'id');
    }

    public function valoracions()
    {
        return $this->hasMany(Valoracions::class, 'espai_id', 'id');
    }

    public function visites()
    {
        return $this->hasMany(Visites::class, 'espai_id', 'id');
    }

    public function puntsinteres()
    {
        return $this->hasMany(PuntsInteres::class, 'espai_id', 'id');
    }
}
