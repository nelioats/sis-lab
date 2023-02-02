@extends('master')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-3 text-gray-800">Adicione {{ $natureza }}</h1>
    <p class="mb-3">Adicione os {{ $natureza }} para constituir o Catálogo.</p>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('listItemCatalogo', ['natureza' => $natureza]) }}">Listar</a></li>
            <li class="breadcrumb-item active" aria-current="page">Inserir</li>
        </ol>
    </nav>

    <div class="row">

        <div class="col-xl-12 col-lg-12 card shadow pb-5 pt-3 mb-3">

            <form action="{{ route('salvarItemCatalogo') }}" method="post" class="p-2">
                @csrf

                <div class="form-group">
                    <label>Nome:</label>
                    <input type="text" name="nome" class="form-control" required>
                </div>

                <div class="form-group" hidden>
                    <input type="text" name="natureza" value="{{ $natureza }}" class="form-control">
                </div>

                @if ($natureza == 'Insumo')
                    <div class="form-group">
                        <label>Classificação:</label>
                        <select class="form-control" id="select_classificacao" name="classificacao"
                            onchange="outraClassificacao()">
                            <option></option>
                            <option value="Vidraria">Vidraria</option>
                            <option value="Reagente">Reagente</option>
                            <option value="Banner">Banner</option>
                            <option value="Jogos Didáticos">Jogos Didáticos</option>
                            <option value="Outros">Outros</option>
                        </select>
                    </div>
                @endif

                <div class="form-group" id="div_classificacao_outra" hidden>
                    <label style="color: red">Classificação (outros):</label>
                    <input type="text" name="classificacao_outra" class="form-control">
                </div>

                <div class="form-group">
                    <label>Descrição Técnica:</label>
                    <textarea class="form-control" name="descricao_tecnica" rows="3" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Inserir {{ $natureza }}</button>
            </form>

        </div>

    </div>
@endsection

@section('js')
    <script>
        function outraClassificacao() {

            var valor_classificacao = document.getElementById("select_classificacao").value;

            div_classificacao_outra.setAttribute("hidden", "hidden");

            if (valor_classificacao == 'Outros') {
                document.getElementById('div_classificacao_outra').removeAttribute('hidden');
            }

        }
    </script>
@endsection
