<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comentaris;
use App\Models\Valoracions;
use App\Models\Espais;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Usuaris extends Model
{
    use HasFactory;
    protected $table = 'usuaris';
    protected $primaryKey = 'id';
    /**
     * Atributos que pueden ser asignados en masa.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'llinatges',
        'dni',
        'mail',
        'contrasenya',
    ];

    protected $with = ['comentaris', 'valoracions', 'espais'];

    public function comentaris()
    {
        return $this->hasMany(Comentaris::class, 'usuari_id', 'id');
    }

    public function valoracions()
    {
        return $this->hasMany(Valoracions::class, 'usuari_id', 'id');
    }

    public function espais()
    {
        return $this->hasMany(Espais::class, 'gestor_id', 'id');
    }
}
