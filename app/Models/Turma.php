<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    use HasFactory;

    protected $fillable = [
        'cod_turma',
        'turno_turma',
    ];

    public function aluno(){
        return $this->belongsTo(Aluno::class);
    }
}
