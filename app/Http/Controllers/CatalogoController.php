<?php

namespace App\Http\Controllers;

use App\Models\Unidade;
use App\Models\Catalogo;
use Illuminate\Http\Request;

class CatalogoController extends Controller
{
    protected $unidades;

    public function __construct()
    {
        $this->unidades = Unidade::all()->except('1');
    }


    public function insertItemCatalogo($natureza){

        $unidades = $this->unidades;
        return view('catalogo.inserirCatalogo',compact(['unidades','natureza']));
    }

    public function salvarItemCatalogo(Request $request){




        $novo_itemCatalogo = new Catalogo;
        $novo_itemCatalogo->nome = $request->nome;
        $novo_itemCatalogo->natureza = $request->natureza;

        if($request->classificacao != "Outros"){
            $novo_itemCatalogo->classificacao = $request->classificacao;
        }else{
            $novo_itemCatalogo->classificacao = $request->classificacao_outra;
        }

        $novo_itemCatalogo->descricao_tecnica = $request->descricao_tecnica;
        $novo_itemCatalogo->save();

        //criando codigo produto
        $ultimoIdSalvo = Catalogo::orderBy('id','desc')->select('id')->first();
        $novo_itemCatalogo->cod_produto = strtoupper(substr($request->natureza, 0, 2)).'-'.'00'.$ultimoIdSalvo->id.date('y');

        $novo_itemCatalogo->save();

        return redirect()->route('listItemCatalogo',['natureza'=> $request->natureza])->with('success', true);
    }

    public function listItemCatalogo($natureza){



        $unidades = $this->unidades;

        $itensCatalogo = Catalogo::where('natureza', $natureza)
        ->orderBy('nome','asc')
        ->get();

     return view('catalogo.listCatalogo',compact(['unidades','itensCatalogo', 'natureza']));
    }

    public function destroyItemCatalogo($id){
        $itemCatalogo = Catalogo::find($id);
        $itemCatalogo->delete();
        return back()->withInput()->with('delete-success', true);
    }
    public function editItemCatalogo($id){
        $unidades = $this->unidades;
        $itemCatalogo = Catalogo::find($id);
        return view('catalogo.editCatalogo',compact(['unidades','itemCatalogo']));
    }

    public function updateItemCatalogo(Request $request, $id)
    {
        $unidades = $this->unidades;

        $itemCatalogo = Catalogo::find($id);
        $itemCatalogo->nome = $request->nome;

        if($request->classificacao != "Outros"){
            $itemCatalogo->classificacao = $request->classificacao;
        }else{
            $itemCatalogo->classificacao = $request->classificacao_outra;
        }

        $itemCatalogo->descricao_tecnica = $request->descricao_tecnica;

        $itemCatalogo->save();

        return redirect()->route('listItemCatalogo',['natureza'=> $itemCatalogo->natureza])->with('update-success', true);



    }
}
