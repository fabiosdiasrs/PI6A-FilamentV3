<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DadosAdicionais extends Model
{
    use HasFactory;

    protected $fillable = [
        'irmao_instituicao',
        'escola',
        'pessoa_id',
        'parentesco_resp',
        'aluno_id',
        'renda_familiar',
        'bolsa_familia',
        'direito_imagem',
    ];

    public function pessoa(){
        return $this->belongsTo(Pessoa::class);
    }
    public function aluno(){
        return $this->belongsTo(Aluno::class);
    }
}
