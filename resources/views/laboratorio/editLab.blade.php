@extends('master')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Editar labororatório <span style="color: blue">{{ $editLaboratorio->prefixo }}</span>
    </h1>
    <p class="mb-4">Edite e atualize as informações do labororatório.</p>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('list_lab', ['baseLab' => $base]) }}">Listar</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar</li>
        </ol>
    </nav>

    <div class="row">

        <div class="col-xl-12 col-lg-12 card shadow pb-5 pt-3 mb-3">

            <form action="{{ route('updatelab', ['id' => $editLaboratorio->id]) }}" method="post" class="p-2">
                @csrf
                <div class="form-group">
                    <label>IEMA Pleno:</label>
                    <select class="form-control" name="unidade_id" disabled>
                        <option></option>
                        @foreach ($unidades as $unidade)
                            <option {{ $editLaboratorio->unidade_id == $unidade->id ? 'selected' : '' }}
                                value="{{ $unidade->id }}">
                                {{ $unidade->nome }}</option>
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
                    <select class="form-control" name="componente_id" disabled>
                        <option></option>
                        @foreach ($componentes as $componente)
                            <option {{ $editLaboratorio->componente_id == $componente->id ? 'selected' : '' }}
                                value="{{ $componente->id }}">{{ $componente->componente }}</option>
                        @endforeach
                    </select>
                </div>



                <div class="form-group">
                    <label>Status:</label>
                    <select class="form-control" name="status">
                        <option></option>
                        <option {{ $editLaboratorio->status == 'Nao Instalado' ? 'selected' : '' }} value="Nao Instalado">
                            Não Instalado</option>
                        <option {{ $editLaboratorio->status == 'Parcialmente Instalado' ? 'selected' : '' }}
                            value="Parcialmente Instalado">Parcialmente Instalado</option>
                        <option {{ $editLaboratorio->status == 'Instalado' ? 'selected' : '' }} value="Instalado">Instalado
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Fornecedor Geral:</label>
                    <input type="text" name="fornecedor" class="form-control"
                        value="{{ $editLaboratorio->fornecedor }}">
                </div>

                <div class="form-group">
                    <label>Aquisicao:</label>
                    <select class="form-control" name="aquisicao" id="select_aquisicao" onchange="outraAquisicao()">
                        <option></option>
                        <option {{ $editLaboratorio->aquisicao == 'IEMA' ? 'selected' : '' }} value="IEMA">IEMA
                        </option>
                        <option {{ $editLaboratorio->aquisicao == 'SEDUC' ? 'selected' : '' }} value="SEDUC">SEDUC
                        </option>
                        <option {{ $editLaboratorio->aquisicao == 'Emenda Parlamentar' ? 'selected' : '' }}
                            value="Emenda Parlamentar">Emenda Parlamentar</option>
                        <option {{ $editLaboratorio->aquisicao == 'Vale' ? 'selected' : '' }} value="Vale">Vale</option>
                        <option {{ $editLaboratorio->aquisicao == 'Ministerio Publico' ? 'selected' : '' }}
                            value="Ministerio Publico">Ministério Público</option>
                        <option
                            {{ $editLaboratorio->aquisicao != 'IEMA' &&
                            $editLaboratorio->aquisicao != 'SEDUC' &&
                            $editLaboratorio->aquisicao != 'Emenda Parlamentar' &&
                            $editLaboratorio->aquisicao != 'Vale' &&
                            $editLaboratorio->aquisicao != 'Ministerio Publico'
                                ? 'selected'
                                : '' }}
                            value="outra">Outra
                        </option>
                    </select>
                </div>

                <div class="form-group" id="div_aquisicao_outra" hidden>
                    <label style="color: red">Aquisicao (outra):</label>
                    <input type="text" name="aquisicao_outra" class="form-control"
                        value="{{ $editLaboratorio->aquisicao }}">
                </div>

                <div class="form-group">
                    <label>Investimento:</label>
                    <select class="form-control" name="investimento">
                        <option></option>
                        <option value="Parcial" {{ $editLaboratorio->investimento == 'Parcial' ? 'selected' : '' }}>Parcial
                        </option>
                        <option value="Total" {{ $editLaboratorio->investimento == 'Total' ? 'selected' : '' }}>Total
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Valor (R$):</label>
                    <input type="text" name="valorLab" class="form-control valor" placeholder="000.000,00"
                        value="{{ $editLaboratorio->valorLab }}">
                </div>



                <div class="form-group">
                    <label>Data prevista de entrega</label>
                    <input type="date" name="data_prevista_entrega" class="form-control"
                        value="{{ $editLaboratorio->getDataprevistaentregaNoFomat($editLaboratorio->id) }}" />

                </div>

                <button type="submit" class="btn btn-primary">Atualizar Lab</button>
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
    @if ($editLaboratorio->aquisicao != 'IEMA' &&
        $editLaboratorio->aquisicao != 'SEDUC' &&
        $editLaboratorio->aquisicao != 'Emenda Parlamentar' &&
        $editLaboratorio->aquisicao != 'Vale' &&
        $editLaboratorio->aquisicao != 'Ministerio Publico')
        <script>
            var valor_aquisicao = document.getElementById("select_aquisicao").value;

            //caso nao seja outra, remover setar o atributo hidden
            div_aquisicao_outra.setAttribute("hidden", "hidden");

            if (valor_aquisicao == 'outra') {
                document.getElementById('div_aquisicao_outra').removeAttribute('hidden');
            }
        </script>
    @endif
@endsection
