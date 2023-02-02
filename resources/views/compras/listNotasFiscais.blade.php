@extends('master')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-3 text-gray-800">Lista de Notas Fiscais</h1>
    <p class="mb-3">Clique no número da nota para adicionar os itens, visualzar ou excluir.</p>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('insertNota') }}">Inserir Nota</a></li>
            <li class="breadcrumb-item active" aria-current="page">Notas Fiscais</li>
        </ol>
    </nav>

    <div class="row">

        <div class="col-xl-12 col-lg-12 card shadow pb-5 pt-3 mb-3">

            <table id="exampleData" style="font-size: 0.9rem" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Número</th>
                        <th>Empresa</th>
                        <th class="text-center">Data da Compra</th>
                        <th class="text-center">Valor total</th>
                        <th class="text-center">Arquivo</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($notasFiscais as $notaFiscal)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>
                                <a style="color: rgb(29, 6, 240)"
                                    href="{{ route('addItensNota', ['id' => $notaFiscal->id]) }}">{{ $notaFiscal->nota_fiscal_numero }}</a>
                            </td>
                            <td>{{ $notaFiscal->empresa }}</td>
                            <td class="text-center">{{ $notaFiscal->data_compra }}</td>
                            <td class="text-right">{{ $notaFiscal->valor_total_nota }}</td>
                            <td class="text-center">
                                <a href="{{ url("storage/$notaFiscal->nota_fiscal_path") }}" target="blank"><i
                                        class='far fa-file'></i></a>
                            </td>
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
                title: 'Nota criada!',
                timer: 1900
            })
        </script>
    @endif

    @if (session()->exists('delete-success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Nota removido!',
                timer: 1900
            })
        </script>
        <script>
            function enviaID() {
                alert('ola');
            }
        </script>
    @endif
@endsection
