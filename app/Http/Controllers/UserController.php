<?php

namespace App\Http\Controllers;

use App\Models\Laboratorio;
use App\Models\User;
use App\Models\Unidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    protected $unidades;

    public function __construct()
    {

        $this->unidades = Unidade::all()->except('1');
    }

    public function showDashBoard(){

        $unidades = $this->unidades;

        $iemasLabQnt = DB::table('unidades')
            ->leftjoin('laboratorios','unidades.id','=','laboratorios.unidade_id')
            ->select('unidades.id','unidades.nome as nome',DB::raw("count(laboratorios.unidade_id) as count"))
            ->groupBy('unidades.id')
            ->where('unidades.id', '!=',1)
            ->get();

        $labComponentesQnt = DB::table('laboratorios')
            ->join('componentes','laboratorios.componente_id','=','componentes.id')
            ->select('componentes.componente',DB::raw("count(laboratorios.componente_id) as count"))
            ->groupBy('componentes.id')
            ->get();

        $usuariosQnt = DB::table('users')
            ->select('perfil', DB::raw('count(*) as count'))
            ->groupBy('perfil')
            ->get();

           // dd($usuariosQnt);


            //dd($unidades);
            //dd($iemasLabQnt);
            //dd($labComponentesQnt);

        return view('dashboard.index',compact('unidades','iemasLabQnt','labComponentesQnt','usuariosQnt'));
    }

    public function listUsers(){

        $usuarios = User::all();

        $unidades = $this->unidades;

        return view('usuario.listUsers',compact(['usuarios','unidades']));
    }

    public function editPerfil(Request $request)
    {
        $usuario = User::find($request->id);
        $unidades = $this->unidades;
        $laboratorios = Laboratorio::where('unidade_id','=',$usuario->unidade_id)->get();

        //dd($laboratorios->prefixo);

         return view('usuario.editPerfil',compact(['usuario','unidades','laboratorios']));


    }

    public function updatePerfil(Request $request, $id)
    {

        $unidades = $this->unidades;

        $user = User::find($id);

        $user->perfil = $request->perfil;
        $user->unidade_id = $request->unidade_id;
        $user->laboratorio_id = $request->laboratorio_id;

        $user->save();
        return redirect()->route('listUsers',['unidades'=>$unidades])->with('atualizacao-success', true);
    }

}

       // if($usuario->perfil == 'coordenador'){
        //     $usuario->perfil = null;
        //     $usuario->save();
        // } else {
        //     $usuario->perfil = 'coordenador';
        //     $usuario->save();
        // }
