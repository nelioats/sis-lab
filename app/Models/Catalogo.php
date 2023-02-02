<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalogo extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome',
        'natureza',
        'cod_produto',    
        'classificacao',    
        'descricao_tecnica',    
    ];


  

}
