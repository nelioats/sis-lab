<?php

namespace App\Http\Controllers;

use App\Models\Unidade;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin(){

        return view('login.login');
    }

    public function showRegister(){

        $unidades = Unidade::all()->except('1');

        return view('login.register',compact('unidades'));
    }

    public function saveUser(Request $request){

            $messages = [
                'password.min' => 'A senha aceita no minímo 5 caracteres!',
                'password.required' => 'O campo senha é obrigatório!',
                'name.required' => 'O campo nome é obrigatório!',
                'email.required' => 'O campo email é obrigatório!',

            ];

            //verificação dos inputs
            $this->validate($request,[
                'password' => 'required|min:5',
                'name' => 'required',
                'email' => 'required',

            ], $messages);

             //verificando se já existe usuário
             //=============================
             $usuario_existente = User::where('email','=',$request->email)
                                    ->first();
            //exisitindo
            //==============================
            if($usuario_existente != null){
                    return back()->with('error', 'Ops, usuário já cadastrado!');
            }

            $userCreate = User::create($request->all());

            return redirect()->route('login')
            ->with('success','Cadastro realizado, entre em contato com ADM para acessar plataforma!');
    }

    public function verificaLogin(Request $request){

        $messages = [
            'password.required' => 'O campo senha é obrigatório!',
            'email.required' => 'O campo email é obrigatório!',
        ];

        //verificação dos inputs
        $this->validate($request,[
            'password' => 'required',
            'email' => 'required',
        ], $messages);

        //verificando se existe usuário=======================
        $usuario = User::where('email','=',$request->email)
          ->first();
        if($usuario == null){
                return redirect()->route('login')
                ->with('error','Ops, usuário não encontrado!');
        }

        //verificar se usuario é ADMIN | GESTOR | PROFESSOR
        if($usuario->perfil != 'Administrador' && $usuario->perfil != 'Gestor' && $usuario->perfil != 'Professor'){
            return redirect()->route('login')
            ->with('error','Entre em contato com ADM para acessar plataforma!');
        }


        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
           //LOGADO


           //VERIFICAR SE JA TEM UMA UNIDADE DEFINIDA - verificacao para os tres perfis
           if($usuario->unidade_id == null){
                Auth::logout();
                return redirect()->route('login')->with('error','Ops, unidade não informada pelo Administrador!');
           }
           //======================================
           //ACESSO PROFESSOR
           //======================================
           //VERIFICAR SE O PROFESSOR JA TEM LABORATORIO VINCULADO
           if($usuario->perfil == 'Professor'){
                if($usuario->laboratorio_id == null){
                    Auth::logout();
                    return redirect()->route('login')->with('error','Ops, laboratório não vinculado pelo Administrador!');
                }
                //se tem laboratorio vinculdo
                return redirect()->route('detalheslab',['id' => $usuario->laboratorio_id]);
           }
           //======================================
           //ACESSO GESTOR
           //======================================
           if($usuario->perfil == 'Gestor'){
                //se tem laboratorio vinculdo
                return redirect()->route('detalhesUnidade',['id' => $usuario->unidade_id]);
            }



            //nao encontrando PROFESSOR O GESTOR, carrega a tela de dashboard
           return redirect()->route('dashboard');

        }else {
            return redirect()->route('login')
            ->with('error','Ops, usuário e senha não correspondem!');
       }

    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }


}
