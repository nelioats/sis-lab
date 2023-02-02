<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Componente extends Model
{
    use HasFactory;
    protected $fillable = [
        'base',
        'componente',     
        'prefixo',     
    ];

    public function getBaseAttribute($value)
    {
           return mb_strtoupper($value, 'UTF-8');
    }
    public function getComponenteAttribute($value)
    {
           return mb_strtoupper($value, 'UTF-8');
    }
    public function getPrefixoAttribute($value)
    {
           return mb_strtoupper($value, 'UTF-8');
    }
}
