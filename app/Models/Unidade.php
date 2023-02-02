<?php

namespace App\Models;

use App\Models\Laboratorio;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unidade extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome',
        'prefixo',
    ];

    public function laboratorios()
    {
        return $this->hasMany(Laboratorio::class,'unidade_id','id');
    }


    public function existComponenteLab($unidade_id,$componente){

        $existComponente = Laboratorio::where('unidade_id','=',$unidade_id)
            ->where('componente','=',$componente)
            ->first();
            return $existComponente;
    }

    public function getValorTotalInvestidoLab($id){

        $valorTotalInvestido = Laboratorio::where('unidade_id','=',$id)->sum('valorLab_total');

        return number_format($valorTotalInvestido,2,',','.');
    }

    public function getInsumos($id){

        $QntInsumos = DB::table('laboratorio_insumos_equipamentos')
        ->join('catalogos', 'laboratorio_insumos_equipamentos.itemCatalogo_id', '=', 'catalogos.id')
        ->select('laboratorio_insumos_equipamentos.*')
        ->where('catalogos.natureza','=','Insumo')
        ->where('unidade_id','=',$id)
        ->get();


        return [$QntInsumos->sum('quantidadeItem'), number_format($QntInsumos->sum('valorTotalItem'),2,',','.')];
    }



    public function getEquipamentos($id){

        $QntEquipamentos = DB::table('laboratorio_insumos_equipamentos')
        ->join('catalogos', 'laboratorio_insumos_equipamentos.itemCatalogo_id', '=', 'catalogos.id')
        ->select('laboratorio_insumos_equipamentos.*')
        ->where('catalogos.natureza','=','Equipamento')
        ->where('unidade_id','=',$id)
        ->get();

        return [$QntEquipamentos->sum('quantidadeItem'), number_format($QntEquipamentos->sum('valorTotalItem'),2,',','.')];
    }


}
