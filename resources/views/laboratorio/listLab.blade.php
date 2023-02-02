@extends('master')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">labororatórios {{ $base }}</h1>
    <p class="mb-4">Clique no <span style="color: #446AD8;"> CÓDIGO </span>do laboratório para mais detalhes.</p>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            @if (auth()->user()->perfil == 'Administrador' && auth()->user()->unidade_id == 1)
                <li class="breadcrumb-item"><a href="{{ route('insertlab', ['baseLab' => $base]) }}">Inserir</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">labororatórios</li>
        </ol>
    </nav>

    <div class="row">

        <div class="col-xl-12 col-lg-12 card shadow pb-5 pt-3 mb-3">

            <table id="exampleData" style="font-size: 0.85rem" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Código</th>
                        <th>IP</th>
                        <th class="text-center">Componente</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Data prevista</th>
                        <th class="text-center">Data de Entrega</th>
                        <th>Valor</th>
                        <th>Valor Total</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($laboratorios as $laboratorio)
                        <tr>

                            <td>{{ $loop->index + 1 }}</td>
                            <td>
                                <a href="{{ route('detalheslab', ['id' => $laboratorio->id]) }}">
                                    {{ $laboratorio->prefixo }}
                                </a>
                            </td>
                            <td>{{ $laboratorio->unidade_lab->nome }}</td>
                            <td class="text-center">{{ $laboratorio->componente->componente }}</td>

                            <td class="text-center"
                                style="{{ $laboratorio->status == 'Parcialmente Instalado' ? 'color: blue; ' : ($laboratorio->status == 'Instalado' ? 'color: rgb(3, 175, 3)' : 'color: red') }}">
                                {{ $laboratorio->status }}</td>


                            <td class="text-center">{{ $laboratorio->data_prevista_entrega }}</td>
                            <td class="text-center">{{ $laboratorio->data_entrega }}</td>
                            <td class="text-right">{{ $laboratorio->valorLab }}</td>
                            <td class="text-right">{{ $laboratorio->valorLab_total }}</td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

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

    @if (session()->exists('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Laboratório criado!',
                timer: 1900
            })
        </script>
    @endif
    @if (session()->exists('delete-success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Laboratório removido!',
                timer: 1900
            })
        </script>
    @endif
@endsection
