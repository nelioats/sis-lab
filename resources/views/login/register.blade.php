@extends('login.master')

@section('conteudo')
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Crie suas credencias!</h1>
    </div>

    @if ($errors->all())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger text-center">
                {{ $error }}
            </div>
        @endforeach
    @endif

    <form class="user" action="{{ route('saveUser') }}" method="POST">
        @csrf
        <div class="form-group">
            <input type="text" name="name" class="form-control form-control-sm p-4" type="text"
                placeholder="Digite seu nome..." required>
        </div>
        <div class="form-group">
            <input type="email" name="email" class="form-control form-control-sm p-4" type="text"
                placeholder="Digite seu e-mail..." required>
        </div>


        <select class="form-control form-control-lg" name="unidade_id"
            style="font-size: 0.875rem; margin-bottom: 15px; margin-top: 10px; padding-bottom: 10px;padding-top: 9px; height: 50px; color: grey;">
            <option value="" selected>Selecione sua IP...</option>
            @foreach ($unidades as $unidade)
                <option value="{{ $unidade->id }}">{{ $unidade->nome }}</option>
            @endforeach
        </select>





        <div class="form-group">
            <input type="password" name="password" class="form-control form-control-sm p-4" placeholder="Digite sua senha"
                required>
        </div>
        <button class="btn btn-primary btn-user btn-block">
            Registrar
        </button>
    </form>
    <div class="text-center mt-3">
        <p>Já tem uma conta? <a href="{{ route('login') }}">Clique aqui</a></p>
    </div>
@endsection
