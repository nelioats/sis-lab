<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaboratorioBemMoveis extends Model
{
    use HasFactory;
    protected $fillable = [
        'itemCatalogo_id',
        'unidade_id',
        'laboratorio_id',
        'quantidadeItem',
        'valorUndItem',
        'valorTotalItem',
    ];

    public function catalogo(){

        //Agora que podemos acessar todos os BemMoveis de um Catalogo, vamos definir um relacionamento para permitir que um Bem Movel acesse sua postagem pai.
        //Para definir o inverso de um relacionamento hasMany, defina um método de relacionamento no modelo filho que chama o método belongsTo:
        //muitos para um(Qual modelo quero me relacionar,  'qual é minha chave estrangeira que faz referencia a esse modelo'   , 'la no modelo, qual campo eu quero comparar')
        return $this->belongsTo(Catalogo::class,'itemCatalogo_id','id');
    }


    public function setValorUndItemAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['valorUndItem'] = floatval($this->convertStringToDouble($value));
        }
    }

    public function setValorTotalItemAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['valorTotalItem'] = floatval($this->convertStringToDouble($value));
        }
    }


    public function getValorUndItemAttribute($value)
    {
           return number_format($value, 2, ',', '.');
    }
    public function getValorTotalItemAttribute($value)
    {
           return number_format($value, 2, ',', '.');
    }

       //=======================================================================
    //FUNCOES HELPERS
    //=======================================================================
    private function convertStringToDouble($param)
    {
        if (empty($param)) {
            return null;
        }

        return  str_replace(',', '.', str_replace('.', '', $param));
    }

}
