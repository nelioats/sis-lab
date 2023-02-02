@extends('master')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-3 text-gray-800">Lista de Componentes</h1>


    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('insertComponente') }}">Inserir</a></li>
            <li class="breadcrumb-item active" aria-current="page">Componentes</li>
        </ol>
    </nav>

    <div class="row">

        <div class="col-xl-12 col-lg-12 card shadow pb-5 pt-3 mb-3">

            <table id="exampleData" style="font-size: 0.9rem" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Prefixo</th>
                        <th>Componente</th>
                        <th>Base</th>
                        <th class="text-center">Editar</th>
                        <th class="text-center">Excluir</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($componentes as $componente)
                        <tr>

                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $componente->prefixo }}</td>
                            <td>{{ $componente->componente }}</td>
                            <td>{{ $componente->base }}</td>
                            <td class="text-center"><a href="{{ route('editComponente', ['id' => $componente->id]) }}"><i
                                        class='far fa-edit'></i></a></td>
                            <td componenteId="{{ $componente->id }}" onclick="recebeID(this)" class="text-center"> <a
                                    href="#"><i class='far fa-trash-alt' data-toggle="modal"
                                        data-target="#destroyComponenteModal"></i></a> </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

    </div>


    <!-- MODAL DESTROY COMPONENTE -->
    <div class="modal fade" id="destroyComponenteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deseja excluir Nota?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Clique em "Excluir" para remover de forma definitiva o componente.
                    <p style="color: red">* Os laboratórios vinculados com esse componente serão removidos.</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary" id="rotaComId" href="">Excluir</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @if (session()->exists('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Componente criado!',
                timer: 1900
            })
        </script>
    @endif

    @if (session()->exists('delete-success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Componente removido!',
                timer: 1900
            })
        </script>
    @endif
    @if (session()->exists('success-upload'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Componente atualizado!',
                timer: 1900
            })
        </script>
    @endif
    <script>
        function recebeID(atributo) {
            var delete_id = atributo.getAttribute('componenteId');
            var rota = "{{ route('destroyComponente', ['id' => ':id']) }}";
            rota = rota.replace(":id", delete_id);
            document.querySelector('#rotaComId').href = rota;
        }
    </script>
@endsection
