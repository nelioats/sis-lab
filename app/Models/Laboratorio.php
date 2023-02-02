<?php

namespace App\Models;

use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Laboratorio extends Model
{
    use HasFactory;
    protected $fillable = [
        'unidade_id',
        'prefixo',
        'base',
        'componente_id',
        'status',
        'data_prevista_entrega',
        'data_entrega',
        'fornecedor',
        'aquisicao',
        'investimento',
        'valorLab',
        'valorLab_total',
        'observacao',
    ];


    public function unidade_lab(){
        return $this->hasOne(Unidade::class,'id','unidade_id');
    }

    public function componente()
    {
        return $this->hasOne(Componente::class,'id','componente_id');
    }

    public function estoques()
    {
        //um para muitos = um usuario pode ter varios companhias
        //um para muitos(Qual modelo quero me relacionar,  'qual id desse modelo me faz referencia'   , 'qual meu id faz referencia a ele')
        return $this->hasMany(Estoque::class, 'laboratorio_id', 'id');
    }


    public function setValorLabAttribute($value)
    {
        if (!empty($value)) {
           $this->attributes['valorLab'] = floatval($this->convertStringToDouble($value));
        }
    }

    public function setvalorLabtotalAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['valorLab_total'] = floatval($this->convertStringToDouble($value));
        }
    }

    // public function setdataPrevistaEntregaAttribute($value)
    // {
    //     if (!empty($value)) {
    //         $this->attributes['data_prevista_entrega'] = $this->convertStringToDate($value);
    //     }
    // }





    public function getValorLabAttribute($value)
    {
           return number_format($value, 2, ',', '.');
    }

    public function getValorLabtotalAttribute($value)
    {
           return number_format($value, 2, ',', '.');
    }

    public function getDataprevistaentregaAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }

    public function getDataprevistaentregaNoFomat()
    {
        $dataFormatada = trim($this->data_prevista_entrega);
        $dataFormatada = date("Y-m-d", strtotime($dataFormatada));
        return $dataFormatada;
    }

    public function getDataentregaAttribute($value)
    {
        if(empty($value)){
            return '';
        }
        return date('d/m/Y', strtotime($value));
    }


    public function getObservacaoAttribute($value)
    {
        return $value;
    }


    public function atualizaValorTotalLab($id){

        $laboratorio = Laboratorio::where('id','=',$id)->first();
        //$valorLab = $laboratorio->valorLab;

        $estoques = DB::table('estoques')
        ->where('laboratorio_id','=', $laboratorio->id)
        ->get('valorTotalItem');

        //dd(number_format($estoques->sum('valorTotalItem') + str_replace(',', '.', str_replace('.', '', $laboratorio->valorLab)),2, ',', '.'));
        $laboratorio->valorLab_total = number_format($estoques->sum('valorTotalItem') + str_replace(',', '.', str_replace('.', '', $laboratorio->valorLab)),2, ',', '.');

        $laboratorio->save();

        //return number_format($estoques->sum('valorTotalItem') + str_replace(',', '.', str_replace('.', '', $valorLab)),2, ',', '.') ;


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

    // private function convertStringToDate($param)
    // {
    //     if (empty($param)) {
    //         return null;
    //     }

    //     list($dia, $mes, $ano) = explode('/', $param);
    //     return (new DateTime($ano . '-' . $mes . '-' . $dia))->format('Y-m-d');
    // }

}
