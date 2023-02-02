@extends('master')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Usuários</h1>
    <p class="mb-4">Altere perfil do usuário para liberar acesso a plataforma</p>

    <div class="row">

        <div class="col-xl-12 col-lg-12 card shadow pb-5 pt-3 mb-3">

            <table id="exampleData" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>IP</th>
                        <th>Perfil</th>
                        <th class="text-center">Editar</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($usuarios as $usuario)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>{{ $usuario->getNomeIP($usuario->unidade_id) }}</td>
                            <td>{{ $usuario->perfil }}</td>
                            <td class="text-center">

                                <a href="{{ route('editPerfil', ['id' => $usuario->id]) }}"><button type="button"
                                        class="btn btn-info">Editar</button></a>

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
    @if (session()->exists('atualizacao-success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Usuário atualizado!',
                timer: 1900
            })
        </script>
    @endif
@endsection
