@extends('login.master')

@section('conteudo')
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Olá! Servidor,</h1>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success text-center">
            {{ $message }}
        </div>
    @endif
    @if ($message = Session::get('error'))
        <div class="alert alert-danger text-center">
            {{ $message }}
        </div>
    @endif

    @if ($errors->all())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger text-center">
                {{ $error }}
            </div>
        @endforeach
    @endif

    <form class="user" action="{{ route('verificaLogin') }}" method="POST">
        @csrf
        <div class="form-group">
            <input type="email" name="email" class="form-control form-control-sm p-4"
                placeholder="Entre com seu e-mail..." required>
        </div>
        <div class="form-group">
            <input type="password" name="password" class="form-control form-control-sm p-4" placeholder="Password" required>
        </div>
        <button class="btn btn-primary btn-user btn-block">
            Login
        </button>
    </form>
    <div class="text-center mt-3">
        <p>Não tem uma conta? <a href="{{ route('register') }}">Clique aqui</a></p>
    </div>
@endsection
