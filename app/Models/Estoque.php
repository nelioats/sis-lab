<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    use HasFactory;
    protected $fillable = [
        'comprasnota_id',
        'unidade_id',
        'laboratorio_id',
        'itemCatalogo_id',
        'codCompraItem',
        'quantidadeItem',
        'valorUndItem',
        'valorTotalItem',

        'emitenteItem',
        'dataEnvioItem',
        'statusItem',
    ];



    public function Catalogo()
    {
        return $this->hasOne(Catalogo::class, 'id','itemCatalogo_id');
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

    public function getDataEnvioItemAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
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
