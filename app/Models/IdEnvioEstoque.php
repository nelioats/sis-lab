<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdEnvioEstoque extends Model
{
    use HasFactory;
    protected $fillable = [
        'unidade_id',
        'laboratorio_id',
        'numDocumento',
        'responsavelEnvio',
        'dataEnvio',
        'dataRecebimento',
        'statusItem',

    ];


    public function getDataEnvioAttribute($value)
    {
        if(empty($value)){
            return '';
        }
        return date('d/m/Y', strtotime($value));
    }

    public function getDataRecebimentoAttribute($value)
    {
        if(empty($value)){
            return '';
        }
        return date('d/m/Y', strtotime($value));
    }

    public function recebeUsuario($id){
        $user = User::find($id);
        return $user->name;
    }


}
