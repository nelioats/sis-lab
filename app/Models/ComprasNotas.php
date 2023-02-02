<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComprasNotas extends Model
{
    use HasFactory;
    protected $fillable = [
        'nota_fiscal_numero',
        'empresa',           
        'data_compra',           
        'valor_total_nota',           
        'nota_fiscal_path',           
        'unidade_id',           
        'laboratorio_id',           
    ];


    public function ComprasNotasItens()
    {
        return $this->hasMany(ComprasNotasItens::class,'comprasnota_id','id');
    }



    public function setValorTotalNotaAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['valor_total_nota'] = floatval($this->convertStringToDouble($value));
        }
    }



    public function getValorTotalNotaAttribute($value)
    {
           return number_format($value, 2, ',', '.');
    }

    public function getDataCompraAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }
   
    public function getDataentregaAttribute($value)
    {
        if(empty($value)){
            return ''; 
        }
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