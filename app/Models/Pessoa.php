<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'dt_nascimento',
        'estado_civil',
        'cpf',
        'rg',
        'nis',
        'email',
        'telefone',
        'sexo',
        'rua',
        'cep',
        'Bairro',
        'numero',
        'pais_id',
        'estado_id',
        'cidade_id',
    ];

    public function pais(){
        return $this->belongsTo(Pais::class);
    }
    public function estado(){
        return $this->belongsTo(Estado::class);
    }
    public function cidade(){
        return $this->belongsTo(Cidade::class);
    }
}
