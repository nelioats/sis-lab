<?php

namespace App\Http\Controllers;

use App\Models\Componente;
use App\Models\Unidade;
use Illuminate\Http\Request;

class ComponenteController extends Controller
{

    protected $unidades;

    public function __construct()
    {
        $this->unidades = Unidade::all()->except('1');
    }

    public function insertComponente()
    {
        $unidades = $this->unidades;
        return view('componentes.inserirComponente',compact('unidades'));
    }


    public function salvarComponente(Request $request)
    {
        $novo_componente = new Componente;
        $novo_componente->base = $request->base;

        $novo_componente->componente = $request->componente;
        $novo_componente->prefixo = $request->prefixo;
        $novo_componente->save();

        return redirect()->route('listComponente')->with('success', true);

    }

    public function listComponente(){
        $unidades = $this->unidades;

            $componentes = Componente::orderBy('base','asc')
            ->orderBy('componente', 'asc')
            ->get();

        return view('componentes.listComponente',compact(['unidades','componentes']));
    }


    public function editComponente($id)
    {
        $unidades = $this->unidades;

        $editComponente = Componente::find($id);

        return view('componentes.editComponente',compact(['unidades','editComponente']));
    }


    public function updateComponente(Request $request, $id)
    {
        $uploadComponente = Componente::find($id);
        $uploadComponente->base = $request->base;
        $uploadComponente->componente = $request->componente;
        $uploadComponente->prefixo = $request->prefixo;

        $uploadComponente->save();
        return redirect()->route('listComponente')->with('success-upload', true);
    }


    public function destroyComponente($id)
    {

        $deletarComponente = Componente::find($id);
        $deletarComponente->delete();
        return back()->withInput()->with('delete-success', true);
    }
}
