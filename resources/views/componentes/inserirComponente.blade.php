@extends('master')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-3 text-gray-800">Adicione Componente</h1>
    <p class="mb-3">De acordo com Base Curricular.</p>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('listComponente') }}">Listar</a></li>
            <li class="breadcrumb-item active" aria-current="page">Inserir</li>
        </ol>
    </nav>

    <div class="row">

        <div class="col-xl-12 col-lg-12 card shadow pb-5 pt-3 mb-3">

            <form action="{{ route('salvarComponente') }}" method="post" class="p-2">
                @csrf

                <div class="form-group">
                    <label>Base Curricular:</label>
                    <select class="form-control" name="base" required>
                        <option></option>
                        <option value="Base Nacional Comum">Base Nacional Comum</option>
                        <option value="Base Técnica">Base Técnica</option>
                    </select>
                </div>


                <div class="form-group">
                    <label>Componente:</label>
                    <input type="text" name="componente" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Prefixo: <span style="color: rgb(165, 165, 165)">(ex: MTM, para componente Matemática, permitido
                            somente 03 caracteres)</span>
                    </label>
                    <input type="text" name="prefixo" maxlength="3" class="form-control" required>
                </div>


                <button type="submit" class="btn btn-primary">Inserir Componente</button>
            </form>


        </div>

    </div>
@endsection
