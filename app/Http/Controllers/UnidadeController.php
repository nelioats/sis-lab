<?php

namespace App\Http\Controllers;

use App\Models\Unidade;
use App\Models\Componente;
use App\Models\Laboratorio;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnidadeController extends Controller
{
    protected $unidades;

    public function __construct()
    {
        $this->unidades = Unidade::all()->except('1');
    }

    public function detalhesUnidade(Request $request){

        $unidades = $this->unidades; // unidades apresentadas no menu

        $unidade = Unidade::find($request->id);

        $laboratoriosUnidade = Laboratorio::where('unidade_id','=',$request->id)
        ->orderBy('componente_id','asc')
        ->get();


        return view('unidades.detalhesUnidade',compact(['unidades','unidade','laboratoriosUnidade']));
    }
}
