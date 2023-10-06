<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'dt_nascimento',
        'cpf',
        'rg',
        'email',
        'ano_escolar',
        'alfabetizado',
        'Etnia',
        'telefone',
        'sexo',
        'rua',
        'cep',
        'complemento',
        'Bairro',
        'numero',
        'is_deficient',
        'pessoa_id',
        'deficiencia_id',
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
    public function pessoa(){
        return $this->belongsTo(Pessoa::class);
    }
    public function deficiencia(){
        return $this->belongsTo(Deficiencia::class);
    }
}
