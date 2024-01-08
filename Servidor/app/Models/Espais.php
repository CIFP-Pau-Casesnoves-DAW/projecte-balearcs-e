<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Espai extends Model
{
    use HasFactory;

    protected $table = 'espais';

    protected $fillable = [
        'nom',
        'descripcio',
        'carrer',
        'numero',
        'pis_porta',
        'web',
        'mail',
        'grau_acc',
        'data_baixa',
        'arquitecte_id',
        'gestor_id',
        'tipus_id',
        'municipi_id'
    ];

    /**
     * Relació amb el model Arquitecte.
     */
    public function arquitecte()
    {
        return $this->belongsTo(Arquitecte::class, 'arquitecte_id');
    }

    /**
     * Relació amb el model Usuari (Gestor).
     */
    public function gestor()
    {
        return $this->belongsTo(Usuari::class, 'gestor_id');
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
        return $this->belongsTo(Municipi::class, 'municipi_id');
    }

    /**
     * Relació amb el model fotos.
     */
    public function fotos()
    {
        return $this->hasMany(Foto::class);
    }   

    


}

