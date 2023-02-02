@extends('master')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Criar labororatório {{ $base }}</h1>
    <p class="mb-4">Adicione o laboratório para depois vincular os insumos e equipamentos.</p>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('list_lab', ['baseLab' => $base]) }}">Listar</a></li>
            <li class="breadcrumb-item active" aria-current="page">Inserir</li>
        </ol>
    </nav>

    <div class="row">

        <div class="col-xl-12 col-lg-12 card shadow pb-5 pt-3 mb-3">

            <form action="{{ route('salvartlab') }}" method="post" class="p-2">
                @csrf
                <div class="form-group">
                    <label>IEMA Pleno:</label>
                    <select class="form-control" name="unidade_id">
                        <option></option>
                        @foreach ($unidades as $unidade)
                            <option value="{{ $unidade->id }}">{{ $unidade->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Base</label>
                    <input type="text" name="base"
                        value="{{ $base == 'BNCC' ? ($base = 'BASE NACIONAL COMUM') : ($base = 'BASE TÉCNICA') }}"
                        class="form-control" readonly>
                </div>


                <div class="form-group">
                    <label>Componente:</label>
                    <select class="form-control" name="componente_id">
                        <option></option>
                        @foreach ($componentes as $componente)
                            <option value="{{ $componente->id }}">{{ $componente->componente }}</option>
                        @endforeach
                    </select>
                </div>



                <div class="form-group">
                    <label>Status:</label>
                    <select class="form-control" name="status">
                        <option></option>
                        <option value="Nao Instalado">Não Instalado</option>
                        <option value="Parcialmente Instalado">Parcialmente Instalado</option>
                        <option value="Instalado">Instalado</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Fornecedor Geral:</label>
                    <input type="text" name="fornecedor" class="form-control">
                </div>

                <div class="form-group">
                    <label>Aquisicao:</label>
                    <select class="form-control" name="aquisicao" id="select_aquisicao" onchange="outraAquisicao()">
                        <option></option>
                        <option value="IEMA">IEMA</option>
                        <option value="SEDUC">SEDUC</option>
                        <option value="Emenda Parlamentar">Emenda Parlamentar</option>
                        <option value="Vale">Vale</option>
                        <option value="Ministerio Publico">Ministério Público</option>
                        <option value="outra">Outra</option>
                    </select>
                </div>

                <div class="form-group" id="div_aquisicao_outra" hidden>
                    <label style="color: red">Aquisicao (outra):</label>
                    <input type="text" name="aquisicao_outra" class="form-control">
                </div>

                <div class="form-group">
                    <label>Investimento:</label>
                    <select class="form-control" name="investimento">
                        <option></option>
                        <option value="Parcial">Parcial</option>
                        <option value="Total">Total</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Valor (R$):</label>
                    <input type="text" name="valorLab" class="form-control valor" placeholder="000.000,00">
                </div>

                <div class="form-group">
                    <label>Data prevista de entrega</label>
                    <input type="date" name="data_prevista_entrega" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Salvar Lab</button>
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
    <script>
        function outraAquisicao() {

            var valor_aquisicao = document.getElementById("select_aquisicao").value;

            //caso nao seja outra, remover setar o atributo hidden
            div_aquisicao_outra.setAttribute("hidden", "hidden");

            if (valor_aquisicao == 'outra') {
                document.getElementById('div_aquisicao_outra').removeAttribute('hidden');
            }

        }
    </script>
@endsection
