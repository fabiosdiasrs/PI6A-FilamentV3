<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'pais_id',
        'estado_id',
    ];

    public function pais(){
        return $this->belongsTo(Pais::class);
    }
    public function estado(){
        return $this->belongsTo(Estado::class);
    }
}
