@extends('master')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-3 text-gray-800">Editar {{ $itemCatalogo->natureza }}</h1>


    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a
                    href="{{ route('insertItemCatalogo', ['natureza' => $itemCatalogo->natureza]) }}">Inserir</a>
            </li>
            <li class="breadcrumb-item"><a
                    href="{{ route('listItemCatalogo', ['natureza' => $itemCatalogo->natureza]) }}">Listar</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $itemCatalogo->cod_produto }}</li>
        </ol>
    </nav>

    <div class="row">

        <div class="col-xl-12 col-lg-12 card shadow pb-5 pt-3 mb-3">

            <form action="{{ route('updateItemCatalogo', ['id' => $itemCatalogo->id]) }}" method="post" class="p-2">
                @csrf

                <div class="form-group">
                    <label>Nome:</label>
                    <input type="text" name="nome" class="form-control" value="{{ $itemCatalogo->nome }}" required>
                </div>

                @if ($itemCatalogo->natureza == 'Insumo')
                    <div class="form-group">
                        <label>Classificação:</label>
                        <select class="form-control" id="select_classificacao" name="classificacao"
                            onchange="outraClassificacao()">
                            <option></option>
                            <option value="Vidraria" {{ $itemCatalogo->classificacao == 'Vidraria' ? 'selected' : '' }}>
                                Vidraria</option>
                            <option value="Reagente" {{ $itemCatalogo->classificacao == 'Reagente' ? 'selected' : '' }}>
                                Reagente</option>
                            <option value="Banner" {{ $itemCatalogo->classificacao == 'Banner' ? 'selected' : '' }}>Banner
                            </option>
                            <option value="Jogos Didáticos"
                                {{ $itemCatalogo->classificacao == 'Jogos Didáticos' ? 'selected' : '' }}>Jogos Didáticos
                            </option>
                            <option value="Outros"
                                {{ $itemCatalogo->classificacao != 'Vidraria' &&
                                $itemCatalogo->classificacao != 'Reagente' &&
                                $itemCatalogo->classificacao != 'Banner' &&
                                $itemCatalogo->classificacao != 'Jogos Didáticos'
                                    ? 'selected'
                                    : '' }}>
                                Outros
                            </option>
                        </select>
                    </div>
                @endif

                <div class="form-group" id="div_classificacao_outra" hidden>
                    <label style="color: red">Classificação (outros):</label>
                    <input type="text" id="classificacao_outra" name="classificacao_outra" class="form-control"
                        value="{{ $itemCatalogo->classificacao }}">
                </div>


                <div class="form-group">
                    <label>Descrição Técnica:</label>
                    <textarea required class="form-control" name="descricao_tecnica" rows="9">{{ $itemCatalogo->descricao_tecnica }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Atualizar {{ $itemCatalogo->natureza }}</button>
            </form>

        </div>

    </div>
@endsection

@section('js')
    <script>
        window.onload = function exampleFunction() {

            var valor_classificacao = document.getElementById("select_classificacao").value;

            if (valor_classificacao == 'Outros') {
                document.getElementById('div_classificacao_outra').removeAttribute('hidden');
            }
        }

        function outraClassificacao() {

            var valor_classificacao = document.getElementById("select_classificacao").value;

            div_classificacao_outra.setAttribute("hidden", "hidden");

            if (valor_classificacao == 'Outros') {
                document.getElementById('div_classificacao_outra').removeAttribute('hidden');
                document.getElementById('classificacao_outra').value = '';
            }

        }
    </script>
@endsection
