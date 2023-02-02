@extends('master')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-3 text-gray-800">Catálogo de {{ $natureza }}</h1>


    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('insertItemCatalogo', ['natureza' => $natureza]) }}">Inserir</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Catálogo de {{ $natureza }}</li>
        </ol>
    </nav>

    <div class="row">

        <div class="col-xl-12 col-lg-12 card shadow pb-5 pt-3 mb-3">

            <table id="exampleData" style="font-size: 0.9rem" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Código</th>
                        <th>Nome</th>

                        @if ($natureza == 'Insumo')
                            <th>Classificação</th>
                        @endif

                        <th>Descrição técnica</th>
                        <th class="text-center">Editar</th>
                        <th class="text-center">Excluir</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($itensCatalogo as $itenCatalogo)
                        <tr>

                            <td>{{ $loop->index + 1 }}</td>
                            <td style="width: 11%;">{{ $itenCatalogo->cod_produto }}</td>
                            <td>{{ $itenCatalogo->nome }}</td>

                            @if ($natureza == 'Insumo')
                                <td>{{ $itenCatalogo->classificacao }}</td>
                            @endif

                            <td style="max-width: 20em; white-space: nowrap; overflow: hidden; text-overflow: ellipsis">
                                {{ $itenCatalogo->descricao_tecnica }}</td>
                            <td class="text-center"><a
                                    href="{{ route('editItemCatalogo', ['id' => $itenCatalogo->id]) }}"><i
                                        class='far fa-edit'></i></a></td>
                            <td class="text-center"> <a
                                    href="{{ route('destroyItemCatalogo', ['id' => $itenCatalogo->id]) }}"><i
                                        class='far fa-trash-alt'></i></a></td>

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
                title: 'Item adicionado!',
                timer: 1900
            })
        </script>
    @endif

    @if (session()->exists('delete-success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Item removido!',
                timer: 1900
            })
        </script>
    @endif

    @if (session()->exists('update-success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Item atualizado!',
                timer: 1900
            })
        </script>
    @endif
@endsection
