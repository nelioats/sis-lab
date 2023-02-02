@extends('master')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-3 text-gray-800">Adicione Notas Fiscais</h1>
    <p class="mb-3">Crie a nota para depois inserir os itens.</p>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('listNotas') }}">Listar</a></li>
            <li class="breadcrumb-item active" aria-current="page">Inserir Nota</li>
        </ol>
    </nav>

    <div class="row">

        <div class="col-xl-12 col-lg-12 card shadow pb-5 pt-3 mb-3">

            <form action="{{ route('salvarNota') }}" method="post" class="p-2" enctype="multipart/form-data">
                @csrf


                <div class="form-group">
                    <label>Número nota fiscal:</label>
                    <input type="text" name="nota_fiscal_numero" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Empresa:</label>
                    <input type="text" name="empresa" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Data da Compra</label>
                    <input type="date" name="data_compra" class="form-control">
                </div>

                <div class="form-group">
                    <label>Valor Total (R$):</label>
                    <input type="text" name="valor_total_nota" class="form-control valor" placeholder="000.000,00">
                </div>


                <div class="form-group">
                    <label>Anexar nota fiscal</label>
                    <input type="file" name="nota_fiscal_path" class="form-control-file">
                </div>




                <button type="submit" class="btn mt-3 btn-primary">Inserir Nota</button>
            </form>

        </div>

    </div>
@endsection


@section('js')
    <script src="{{ url(asset('js/jquery.mask.min.js')) }}"></script>
    <script>
        $(document).ready(function() {
            $(".valor").mask("000.000,00", {
                reverse: true
            });
            $(".cpf").mask("000.000.000-00");
            $(".telefone").mask("(99) 99999-9999");
            $(".date").mask("00/00/0000");
        });
    </script>
@endsection
