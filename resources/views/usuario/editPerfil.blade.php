@extends('master')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $usuario->name }}</h1>
    <ul style="font-size: 85%">
        <li>Para acesso Adm, selecione Diretorio Geral no campo IP e Administrador para perfil.</li>
        <li>Para acesso de Gestor, defina seu perfil.</li>
        <li>Para acesso de Professor, defina seu perfil e vincule no seu respectivo laboratório.</li>
    </ul>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('listUsers') }}">Listar</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar Perfil</li>
        </ol>
    </nav>


    <div class="row">

        <div class="col-xl-12 col-lg-12 card shadow pb-5 pt-3 mb-3">



            <div class="form-group" style="padding-left: 8px">
                <label>E-mail:</label>
                <input type="text" class="form-control" value="{{ $usuario->email }}" disabled>
            </div>

            <form action="{{ route('updatePerfil', ['id' => $usuario->id]) }}" method="post" class="p-2">
                @csrf

                <div class="form-group">
                    <label>IP:</label>
                    @if ($usuario->unidade_id == null)
                        <select class="form-control" name="unidade_id">
                            <option></option>
                            @foreach ($unidades as $unidade)
                                <option value="{{ $unidade->id }}">{{ $unidade->nome }}</option>
                            @endforeach
                        </select>
                    @else
                        <input type="text" name="unidade_id" value="{{ $usuario->unidade_id }}" hidden>
                        <input type="text" class="form-control" value="{{ $usuario->getNomeIP($usuario->unidade_id) }}"
                            readonly>
                    @endif
                </div>

                <div class="form-group">
                    <label>Perfil:</label>
                    <select class="form-control" name="perfil" required>
                        <option></option>
                        <option {{ $usuario->perfil == 'Administrador' ? 'selected' : '' }} value="Administrador">
                            Administrador</option>
                        <option {{ $usuario->perfil == 'Gestor' ? 'selected' : '' }} value="Gestor">Gestor</option>
                        <option {{ $usuario->perfil == 'Professor' ? 'selected' : '' }} value="Professor">Professor
                        </option>

                    </select>
                </div>

                <div class="form-group">
                    <label>Laboratório:</label>
                    <select class="form-control" name="laboratorio_id">
                        <option></option>
                        @foreach ($laboratorios as $laboratorio)
                            <option {{ $laboratorio->id == $usuario->laboratorio_id ? 'selected' : '' }}
                                value="{{ $laboratorio->id }}">
                                {{ $laboratorio->prefixo }} -
                                {{ $laboratorio->componente->componente }}</option>
                        @endforeach
                    </select>
                </div>




                <button type="submit" class="btn btn-primary">Atualizar Perfil</button>
            </form>



        </div>

    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $("#exampleData").DataTable({
                language: {
                    decimal: "",
                    emptyTable: "Não foram encontrados registros",
                    info: "Apresentar _START_ de _END_ para _TOTAL_ registros",
                    infoEmpty: "Apresentar 0 de 0 para 0 registros",
                    infoFiltered: "(filtered from _MAX_ total entries)",
                    infoPostFix: "",
                    thousands: ",",
                    lengthMenu: "Apresentar _MENU_ registros",
                    loadingRecords: "Loading...",
                    processing: "",
                    search: "Pesquisar:",
                    zeroRecords: "No matching records found",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Próximo",
                        previous: "Anterior",
                    },
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending",
                    },
                },
            });
        });
    </script>
@endsection
