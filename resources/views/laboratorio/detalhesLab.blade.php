@extends('master')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $laboratorio->prefixo }}</h1>

    <p class="mb-4">Insira data de entrega, observações, insumos e equipamentos.</p>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            @if (auth()->user()->perfil == 'Administrador' && auth()->user()->unidade_id == 1)
                <li class="breadcrumb-item"><a href="{{ route('list_lab', ['baseLab' => $base]) }}">Listar</a></li>
                <li class="breadcrumb-item"><a href="{{ route('insertlab', ['baseLab' => $base]) }}">Inserir</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">Detalhes</li>


            </li>
        </ol>
    </nav>



    <div class="row">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="informeGeral-tab" data-toggle="tab" href="#informeGeral" role="tab"
                    aria-controls="informeGeral" aria-selected="true">Informações Gerais</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="itensInsEqu-tab" data-toggle="tab" href="#itensInsEqu" role="tab"
                    aria-controls="itensInsEqu" aria-selected="false">Itens (Insumos / Equipamentos)</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="bensmoveis-tab" data-toggle="tab" href="#bensmoveis" role="tab"
                    aria-controls="bensmoveis" aria-selected="false">Bens móveis</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="itensEnviados-tab" data-toggle="tab" href="#itensEnviados" role="tab"
                    aria-controls="itensEnviados" aria-selected="false">Itens Recebidos</a>
            </li>
        </ul>
    </div>

    <div class="row">

        <div class="col-xl-12 col-lg-12 card shadow pb-5 pt-3 mb-3">

            <div class="tab-content" id="myTabContent">

                {{-- INFORMAÇÕES GERAIS --}}
                <div class="tab-pane fade show active" id="informeGeral" role="tabpanel" aria-labelledby="informeGeral-tab">

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">IP:</th>
                                <td scope="col">{{ $laboratorio->unidade_lab->nome }}</td>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <th scope="col">Base:</th>
                                <td scope="col">{{ $laboratorio->base }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Componente:</th>
                                <td>{{ $laboratorio->componente->componente }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Status:</th>
                                <td
                                    style="{{ $laboratorio->status == 'Parcialmente Instalado' ? 'color: blue; ' : ($laboratorio->status == 'Instalado' ? 'color: rgb(3, 175, 3)' : 'color: red') }}">
                                    {{ $laboratorio->status }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Data prevista de entrega:</th>
                                <td>{{ $laboratorio->data_prevista_entrega }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Data Entrega:</th>
                                @if ($laboratorio->data_entrega == '')
                                    <td>
                                        <form action="{{ route('salvardataEntrega', ['id' => $laboratorio->id]) }}"
                                            method="POST" class="form-inline">
                                            @csrf
                                            <input style="width: 70%;" type="date" name="data_entrega"
                                                class="form-control" required>
                                            <button type="submit" class="btn btn-success ml-1"
                                                {{ auth()->user()->perfil == 'Administrador' && auth()->user()->unidade_id == 1 ? '' : 'disabled' }}><i
                                                    class="fa fa-save"></i></button>
                                        </form>
                                    </td>
                                @else
                                    <td style="color: red">{{ $laboratorio->data_entrega }}</td>
                                @endif
                            </tr>


                            @if (auth()->user()->perfil == 'Administrador' && auth()->user()->unidade_id == 1)
                                <tr>
                                    <th scope="row">Fornecedor Geral:</th>
                                    <td>{{ $laboratorio->fornecedor }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Aquisicao:</th>
                                    <td>{{ $laboratorio->aquisicao }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Investimento financeiro:</th>
                                    <td>{{ $laboratorio->investimento }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Valor do laboratório:</th>
                                    <td>R$ {{ $laboratorio->valorLab }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Qnt de variedade(s) de Insumo(s):</th>
                                    <td>{{ $laboratorioInsumos->groupby('itemCatalogo_id')->count() }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Valor total de Insumo(s):</th>
                                    <td>R$ {{ number_format($laboratorioInsumos->sum('valorTotalItem'), 2, ',', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Qnt de variedade(s) de Equipamento(s):</th>
                                    <td>{{ $laboratorioEquipamentos->groupby('itemCatalogo_id')->count() }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Valor total de Equipamento(s):</th>
                                    <td>R$
                                        {{ number_format($laboratorioEquipamentos->sum('valorTotalItem'), 2, ',', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Valor total do Laboratório:</th>
                                    <td style="color: red;">
                                        R$ {{ $laboratorio->valorLab_total }}
                                    </td>
                                </tr>
                            @endif


                        </tbody>
                    </table>

                </div>
                {{-- FIM INFORMACOES GERAIS --}}

                {{-- Itens (Insumos / Equipamentos) --}}
                <div class="tab-pane fade" id="itensInsEqu" role="tabpanel" aria-labelledby="itensInsEqu-tab">

                    @if (auth()->user()->perfil == 'Administrador' || auth()->user()->perfil == 'Professor')
                        <a class="btn btn-info" href="#" data-toggle="modal" data-target="#inserirInsumo"><i
                                class="fa fa-save"></i>
                            Adicionar Insumos
                        </a>
                    @endif


                    <table class="table table-striped mt-3">
                        <tbody>

                            <tr>
                                <td colspan="6" style="font-weight: bold; background-color: #dddddd">Insumos</td>
                            </tr>


                            @if ($laboratorioInsumos->count() == 0)
                                <td colspan="6" class="text-center" style="color: red"> sem registros!</td>
                            @else
                                <tr>
                                    <th class="text-center" scope="row">#</th>
                                    <th scope="row">Item:</th>
                                    <td class="text-center">Qnt</td>
                                    {{-- @if (auth()->user()->perfil == 'Administrador' && auth()->user()->unidade_id == 1) --}}
                                    {{-- <td class="text-center">Valor Und (R$)</td>
                                        <td class="text-center">Data de Envio</td> --}}
                                    {{-- <td class="text-center">Devolver Estoque</td>
                                    @endif --}}
                                </tr>
                                @foreach ($laboratorioInsumos as $item)
                                    <tr>
                                        <td class="text-center">{{ $loop->index + 1 }}</td>
                                        <th scope="row" style="font-weight: normal;">
                                            {{ $item->nome }}</th>
                                        <td class="text-center">{{ $item->quantidadeItem }}</td>
                                        @if (auth()->user()->perfil == 'Administrador' && auth()->user()->unidade_id == 1)
                                            {{-- <td class="text-center">{{ number_format($item->valorUndItem, 2, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                {{ $item->dataEnvioItem == null ? '' : date_format(date_create($item->dataEnvioItem), 'd/m/Y') }}
                                            </td> --}}
                                            {{-- <td class="text-center" estoqueItemId="{{ $item->id }}"
                                                estoqueItemNome="{{ $item->nome }}"
                                                devolve_estoqueComprasnota_id="{{ $item->comprasnota_id }}"
                                                devolve_estoqueItemCatalogo_id="{{ $item->itemCatalogo_id }}"
                                                devolve_estoqueCodCompraItem="{{ $item->codCompraItem }}"
                                                devolve_estoqueQuantidadeItem="{{ $item->quantidadeItem }}"
                                                devolve_estoqueValorUndItem="{{ $item->valorUndItem }}"
                                                onclick="receberDados(this)">
                                                <a href="#" class="btn btn-warning btn-circle btn-sm"
                                                    data-toggle="modal" data-target="#exampleModalEstoque">
                                                    <i class="fas fa-warehouse"></i>
                                                </a>
                                            </td> --}}
                                        @endif
                                    </tr>
                                @endforeach
                            @endif

                            @if (auth()->user()->perfil == 'Administrador' || auth()->user()->perfil == 'Professor')
                                <a class="btn btn-info" href="#" data-toggle="modal"
                                    data-target="#inserirEquipamentos"><i class="fa fa-save"></i>
                                    Adicionar Equipamentos
                                </a>
                            @endif

                            <tr>
                                <td colspan="6" style="font-weight: bold; background-color: #dddddd">Equipamentos</td>
                            </tr>

                            @if ($laboratorioEquipamentos->count() == 0)
                                <td colspan="6" class="text-center" style="color: red"> sem registros!</td>
                            @else
                                <tr>
                                    <th class="text-center" scope="row">#</th>
                                    <th scope="row">Item:</th>
                                    <td class="text-center">Qnt</td>
                                    {{-- @if (auth()->user()->perfil == 'Administrador' && auth()->user()->unidade_id == 1) --}}
                                    {{-- <td class="text-center">Valor Und (R$)</td> --}}
                                    {{-- <td class="text-center">Data de Envio</td> --}}
                                    {{-- <td class="text-center">Devolver Estoque</td>
                                    @endif --}}
                                </tr>
                                @foreach ($laboratorioEquipamentos as $item)
                                    <tr>
                                        <td class="text-center">{{ $loop->index + 1 }}</td>
                                        <th scope="row" style="font-weight: normal;">
                                            {{ $item->nome }}</th>
                                        <td class="text-center">{{ $item->quantidadeItem }}</td>
                                        @if (auth()->user()->perfil == 'Administrador' && auth()->user()->unidade_id == 1)
                                            {{-- <td class="text-center">{{ number_format($item->valorUndItem, 2, ',', '.') }}
                                            </td> --}}
                                            {{-- <td class="text-center">
                                                {{ $item->dataEnvioItem == null ? '' : date_format(date_create($item->dataEnvioItem), 'd/m/Y') }}
                                            </td> --}}
                                            {{-- <td class="text-center" estoqueItemId="{{ $item->id }}"
                                                estoqueItemNome="{{ $item->nome }}"
                                                devolve_estoqueComprasnota_id="{{ $item->comprasnota_id }}"
                                                devolve_estoqueItemCatalogo_id="{{ $item->itemCatalogo_id }}"
                                                devolve_estoqueCodCompraItem="{{ $item->codCompraItem }}"
                                                devolve_estoqueQuantidadeItem="{{ $item->quantidadeItem }}"
                                                devolve_estoqueValorUndItem="{{ $item->valorUndItem }}"
                                                onclick="receberDados(this)">
                                                <a href="#" class="btn btn-warning btn-circle btn-sm"
                                                    data-toggle="modal" data-target="#exampleModalEstoque">
                                                    <i class="fas fa-warehouse"></i>
                                                </a>
                                            </td> --}}
                                        @endif
                                    </tr>
                                @endforeach
                            @endif




                        </tbody>
                    </table>

                </div>
                {{-- FIM Itens (Insumos / Equipamentos) --}}

                {{-- BENS MOVEIS --}}
                <div class="tab-pane fade" id="bensmoveis" role="tabpanel" aria-labelledby="bensmoveis">
                    @if (auth()->user()->perfil == 'Administrador' && auth()->user()->unidade_id == 1)
                        <a class="btn btn-info" href="#" data-toggle="modal" data-target="#inserirBensMoveis"><i
                                class="fa fa-save"></i>
                            Inserir Bens móveis
                        </a>
                    @endif
                    <table class="table table-striped mt-3">
                        <tbody>


                            @if ($bensMoveisLab->count() == 0)
                                <td colspan="6" class="text-center" style="color: red"> sem registros!</td>
                            @else
                                <tr>
                                    <th class="text-center" scope="row">#</th>
                                    <th scope="row">Item:</th>
                                    <td class="text-center">Qnt</td>
                                    @if (auth()->user()->perfil == 'Administrador' && auth()->user()->unidade_id == 1)
                                        <td class="text-center">Valor Und (R$)</td>
                                        <td class="text-center">Valor Total (R$)</td>
                                    @endif
                                </tr>
                                @foreach ($bensMoveisLab as $item)
                                    <tr>
                                        <td class="text-center">{{ $loop->index + 1 }}</td>
                                        <th scope="row" style="font-weight: normal;">
                                            {{ $item->catalogo->nome }}</th>
                                        <td class="text-center">{{ $item->quantidadeItem }}</td>
                                        @if (auth()->user()->perfil == 'Administrador' && auth()->user()->unidade_id == 1)
                                            <td class="text-center">{{ $item->valorUndItem }}</td>
                                            <td class="text-center">{{ $item->valorTotalItem }}
                                        @endif
                                        </td>

                                    </tr>
                                @endforeach
                            @endif

                        </tbody>
                    </table>



                </div>
                {{-- FIM Bens móveis --}}

                {{-- ITENS ENVIADOS --}}
                <div class="tab-pane fade" id="itensEnviados" role="tabpanel" aria-labelledby="itensEnviados">

                    <table class="table table-striped mt-3">
                        <tbody>




                            @if ($documentosEnviados->count() == 0)
                                <td colspan="6" class="text-center" style="color: red"> sem registros!</td>
                            @else
                                <tr>
                                    <td colspan="7" style="font-weight: bold; background-color: #dddddd">Documentos
                                        Enviados</td>
                                </tr>
                                <tr>
                                    <th class="text-center" scope="row">#</th>
                                    <th scope="row">Código do documento:</th>
                                    <th scope="row">Emitente</th>
                                    <th scope="row">Data de envio</th>
                                    <th scope="row">Data de recebimento</th>
                                    <th scope="row">Status</th>
                                    <th scope="row">Visualizar</th>

                                </tr>
                                @foreach ($documentosEnviados as $item)
                                    <tr>
                                        <td class="text-center">{{ $loop->index + 1 }}</td>
                                        <td class="">{{ $item->numDocumento }}</td>
                                        <td class="">{{ $item->recebeUsuario($item->responsavelEnvio) }}</td>
                                        <td class="">{{ $item->dataEnvio }}</td>
                                        <td class="">{{ $item->dataRecebimento }}</td>
                                        <td style="{{ $item->statusItem == 'pendente' ? 'color:red;' : 'color:green;' }}">
                                            {{ $item->statusItem }}</td>
                                        <td class="">

                                            <a href="#" data-toggle="modal" status="{{ $item->statusItem }}"
                                                data-target="#listarItensEnviados" id_envio="{{ $item->id }}"
                                                onclick="listarRecebidos(this)"><span
                                                    class="btn btn-info btn-circle btn-sm"><i class="fa fa-search-plus"
                                                        aria-hidden="true"></i></span>
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach
                            @endif


                        </tbody>
                    </table>


                </div>
                {{-- FIM ITENS ENVIADOS --}}



                {{-- RODAPE BOTTOES --}}
                <table class="table table-striped">

                    <tbody>

                        <tr>
                            <td colspan="2"><strong> Observações / Pedidos:</strong>

                                <form action="{{ route('salvarObsesrvacao', ['id' => $laboratorio->id]) }}"
                                    method="POST" class="">
                                    @csrf
                                    <textarea type="text" name="observacao" class="form-control" rows="3" required></textarea>
                                    <button type="submit" class="btn btn-success mt-2"><i class="fa fa-save">
                                        </i> Atualizar</button>

                                </form>

                                <p> {!! $laboratorio->observacao !!}</p>

                            </td>
                        </tr>
                        @if (auth()->user()->perfil == 'Administrador' && auth()->user()->unidade_id == 1)
                            <tr>
                                <td colspan="2">


                                    <a class="btn btn-warning" href="{{ route('estoque') }}"><i class="fa fa-save"></i>
                                        Estoque</a>

                                    <a href="{{ route('editlab', ['id' => $laboratorio->id]) }}" class="btn btn-info">
                                        <i class='far fa-edit'></i> Editar
                                    </a>

                                    <a href="{{ route('destroyLab', ['id' => $laboratorio->id]) }}"
                                        class="btn btn-danger" data-toggle="modal" data-target="#destroyLabModal">
                                        <i class="far fa-trash-alt"></i> Exluir
                                    </a>
                                </td>
                            </tr>
                        @endif


                    </tbody>
                </table>

            </div>

        </div>

    </div>


    <!-- MODAL DESTROY LABORATORIO -->
    <div class="modal fade" id="destroyLabModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deseja excluir laboratório?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Clique em "Excluir" para remover de forma definitiva o laboratório.
                    <p style="color: red; font-size: 90%;">*Todos os Insumos e Equipamentos serão devolvidos para estoque!
                    </p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary" href="{{ route('destroyLab', ['id' => $laboratorio->id]) }}">Excluir</a>
                </div>
            </div>
        </div>
    </div>


    <!-- MODAL DEVOLUCAO PARA ESTOQUE -->
    <div class="modal fade" id="exampleModalEstoque" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabelEstoque" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelEstoque"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong style="color: red">Quantidade disponível para devolução: <span
                                id="Modal_devolve_EstoqueQuantidadeItem"></span></strong>
                    </p>
                    <form action="{{ route('devolverEstoque') }}" method="post">
                        @csrf

                        <input type="number" id="Modal_devolve_estoqueItemId" name="devolve_estoqueItemId" hidden>
                        <input type="text" id="Modal_devolve_EstoqueComprasnota_id"
                            name="devolve_estoque_comprasnota_id" hidden>
                        <input type="text" id="Modal_devolve_EstoqueItemCatalogo_id"
                            name="devolve_estoque_itemCatalogo_id" hidden>
                        <input type="text" id="Modal_devolve_EstoqueCodCompraItem"
                            name="devolve_estoque_codCompraItem" hidden>
                        <input type="text" id="Modal_devolve_EstoqueValorUndItem" name="devolve_estoque_valorUndItem"
                            hidden>


                        <div class="form-group">
                            <label>Informe a quantidade:</label>
                            <div class="form-group pl-0  border-bottom">
                                <input id="Modal_devolve_EstoqueQuantidadeItem_Max" type="number"
                                    name="devolve_estoque_quantidade" class="form-control" min="1" max=""
                                    required>
                            </div>
                        </div>

                        <input id="Modal_limite_disponivel" type="number" name="limite_disponivel" class="form-control"
                            hidden>

                        {{-- para atualizar valorTotalLab    --}}
                        <input type="text" value="{{ $laboratorio->id }}" name="lab_id" hidden>


                        <div class="float-right">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                onclick="limpandoCampos()">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>


    <!-- MODAL BENS MOVEIS -->
    <div class="modal fade" id="inserirBensMoveis" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalinserirBensMoveis" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Catálogo de Bens móveis</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong style="color: red">Selecione item e informe seus dados: <span></span></strong>
                    </p>


                    <form action="{{ route('salvarBensMoveis') }}" method="post">
                        @csrf

                        <label>Item:</label>
                        <select class="form-control" name="itemCatalogo_id" required>
                            <option></option>
                            @foreach ($CatalogoBensMoveis as $item)
                                <option value="{{ $item->id }}">{{ $item->nome }}</option>
                            @endforeach
                        </select>

                        <input type="text" value="{{ $laboratorio->unidade_id }}" name="unidade_id" hidden>
                        <input type="text" value="{{ $laboratorio->id }}" name="laboratorio_id" hidden>

                        <div class="form-group mt-2">
                            <label>Informe a quantidade:</label>
                            <div class="form-group pl-0  border-bottom">
                                <input id="ModBemMoveisQnt" onchange="resValorTotal()" type="number"
                                    name="quantidadeItem" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label>Valor Und:</label>
                                <div class="form-group pl-0  border-bottom">
                                    <input id="ModBemMoveisValorUnd" onchange="resValorTotal()" type="text"
                                        name="valorUndItem" class="valor form-control">
                                </div>
                            </div>
                            <div class="form-group col-md-7">
                                <label class="">Valor total:</label>
                                <div class="form-group pl-0 border-bottom">
                                    <input id="ModBemMoveisValorTotal" type="text" name="valorTotalItem"
                                        class="valor form-control" readonly>
                                </div>
                            </div>

                        </div>



                        <div class="float-right">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                onclick="">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- MODAL INSUMOS -->
    <div class="modal fade" id="inserirInsumo" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalinserirInsumo" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Catálogo de Insumos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong style="color: red">Selecione item e informe sua quantidade: <span></span></strong>
                    </p>


                    <form action="{{ route('salvarInsumosEquipamentos') }}" method="post">
                        @csrf

                        <label>Item:</label>
                        <select class="form-control" name="itemCatalogo_id" required>
                            <option></option>
                            @foreach ($CatalogoInsumos as $item)
                                <option value="{{ $item->id }}">{{ $item->nome }}</option>
                            @endforeach
                        </select>

                        <input type="text" value="{{ $laboratorio->unidade_id }}" name="unidade_id" hidden>
                        <input type="text" value="{{ $laboratorio->id }}" name="laboratorio_id" hidden>

                        <div class="form-group mt-2">
                            <label>Informe a quantidade:</label>
                            <div class="form-group pl-0  border-bottom">
                                <input id="ModBemMoveisQnt" type="number" name="quantidadeItem" class="form-control"
                                    required>
                            </div>
                        </div>

                        <div class="float-right">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                onclick="">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- MODAL EQUIPAMENTOS -->
    <div class="modal fade" id="inserirEquipamentos" tabindex="-1"
        role="dialog"aria-labelledby="exampleModalinserirEquipamentos" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Catálogo de Equipamentos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong style="color: red">Selecione item e informe sua quantidade: <span></span></strong>
                    </p>


                    <form action="{{ route('salvarInsumosEquipamentos') }}" method="post">
                        @csrf

                        <label>Item:</label>
                        <select class="form-control" name="itemCatalogo_id" required>
                            <option></option>
                            @foreach ($CatalogoEquipamentos as $item)
                                <option value="{{ $item->id }}">{{ $item->nome }}</option>
                            @endforeach
                        </select>

                        <input type="text" value="{{ $laboratorio->unidade_id }}" name="unidade_id" hidden>
                        <input type="text" value="{{ $laboratorio->id }}" name="laboratorio_id" hidden>

                        <div class="form-group mt-2">
                            <label>Informe a quantidade:</label>
                            <div class="form-group pl-0  border-bottom">
                                <input id="ModBemMoveisQnt" type="number" name="quantidadeItem" class="form-control"
                                    required>
                            </div>
                        </div>

                        <div class="float-right">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                onclick="">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- MODAL ITENS ENVIADOS -->
    <div class="modal fade" id="listarItensEnviados" tabindex="-1"
        role="dialog"aria-labelledby="exampleModallistarItensEnviados" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Lista de itens enviados</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong style="color: red">Verifique os itens e seus quantitativos<span></span></strong>
                    </p>


                    <form action="{{ route('confirmarRecebimento') }}" method="post">
                        @csrf

                        <input type="number" value="" name="id_envio" id="id_envio_modal" hidden>
                        <input type="number" value="{{ $laboratorio->id }}" name="id_lab" hidden>
                        <input type="number" value="{{ $laboratorio->unidade_id }}" name="id_unidade" hidden>

                        <table class="table">

                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Descrição</th>
                                    <th scope="col">Qnt</th>
                                </tr>
                            </thead>
                            <tbody id="tablelistaItensRecebidos">

                            </tbody>
                        </table>
                        <div class="mb-3">
                            <p><strong style="color: red">Informe data de recimento e confirme<span></span></strong>
                            </p>
                            <input style="width: 60%;" type="date" name="data_recebimento" class="form-control"
                                required>
                        </div>
                        <div class="float-right">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                onclick="">Cancelar</button>
                            <button type="submit" id="btnConfirmarRecebimento" class="btn btn-primary">Confirmar
                                recebimento</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>


@endsection

@section('js')
    <script>
        function receberDados(componente) {
            //preenchendo
            var estoqueItemId = componente.getAttribute('estoqueItemId');
            var estoqueItemNome = componente.getAttribute('estoqueItemNome');
            var devolve_estoqueComprasnota_id = componente.getAttribute('devolve_estoqueComprasnota_id');
            var devolve_estoqueItemCatalogo_id = componente.getAttribute('devolve_estoqueItemCatalogo_id');
            var devolve_estoqueCodCompraItem = componente.getAttribute('devolve_estoqueCodCompraItem');
            var devolve_estoqueQuantidadeItem = componente.getAttribute('devolve_estoqueQuantidadeItem');
            var devolve_estoqueValorUndItem = componente.getAttribute('devolve_estoqueValorUndItem');

            document.querySelector("#Modal_devolve_estoqueItemId").value = estoqueItemId;
            document.querySelector("#exampleModalLabelEstoque").innerHTML = estoqueItemNome;
            document.querySelector("#Modal_devolve_EstoqueComprasnota_id").value = devolve_estoqueComprasnota_id;
            document.querySelector("#Modal_devolve_EstoqueItemCatalogo_id").value = devolve_estoqueItemCatalogo_id;
            document.querySelector("#Modal_devolve_EstoqueCodCompraItem").value = devolve_estoqueCodCompraItem;
            document.querySelector("#Modal_devolve_EstoqueQuantidadeItem").innerHTML = devolve_estoqueQuantidadeItem;
            document.querySelector("#Modal_devolve_EstoqueQuantidadeItem_Max").max = devolve_estoqueQuantidadeItem;
            document.querySelector("#Modal_devolve_EstoqueValorUndItem").value = devolve_estoqueValorUndItem;
            document.querySelector("#Modal_limite_disponivel").value = devolve_estoqueQuantidadeItem;

        }

        function limpandoCampos() {
            document.querySelector("#Modal_EstoqueQuantidadeItem_Max").value = '';
        }

        function resValorTotal() {
            var qnt = document.querySelector('#ModBemMoveisQnt').value;
            var ValorUnd = document.querySelector('#ModBemMoveisValorUnd').value;
            var valorUndFormat = (ValorUnd.replace(".", "")).replace(",", ".");

            var valorTotal = (qnt * valorUndFormat);
            console.log('quantidade = ' + qnt);
            console.log('Valor unidade = ' + ValorUnd);
            console.log('Valor Total = ' + valorTotal);

            document.querySelector('#ModBemMoveisValorTotal').value = valorTotal.toLocaleString('pt-br', {
                minimumFractionDigits: 2
            });

        }

        async function listarRecebidos(dados) {


            let idEnvio = dados.getAttribute('id_envio');

            let url = "{{ route('list_itens_enviados', ['id' => ':id']) }}";
            url = url.replace(":id", idEnvio);

            // let selectCriados = '';

            await fetch(url)
                .then(response => response.json())
                .then(resultado => {


                    //se documento ja foi entregue, desativar botar de confirmar recebimento
                    if (dados.getAttribute('status') == 'entregue') {
                        document.querySelector("#btnConfirmarRecebimento").disabled = true;
                        document.querySelector("#btnConfirmarRecebimento").innerHTML = 'Documento recebido';
                    }

                    let table = document.querySelector('#tablelistaItensRecebidos');

                    table.innerHTML = '';

                    //definindo id_envio para ser enviado via post
                    document.querySelector('#id_envio_modal').value = idEnvio;

                    resultado.map((item, index) => {
                        let row = document.createElement("tr");

                        let cel1 = document.createElement("td");
                        let cel2 = document.createElement("td");
                        let cel3 = document.createElement("td");

                        cel1.innerHTML = index + 1;
                        cel2.innerHTML = item.itemNome;
                        cel3.innerHTML = item.quantidadeItem;


                        row.appendChild(cel1);
                        row.appendChild(cel2);
                        row.appendChild(cel3);


                        table.appendChild(row);


                    })

                    // resultado.map((indice) => {
                    //     selectCriados += "<option value=" + indice.id + ">" + indice.prefixo + "</option>";
                    // })
                    // laboratorios.innerHTML = selectCriados;
                })






        }
    </script>
    @if (session()->exists('data-success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Data inserida!',
                timer: 1900
            })
        </script>
    @endif
    @if (session()->exists('obs-success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Observação salva!',
                timer: 1900
            })
        </script>
    @endif
    @if (session()->exists('devolucao-success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Item devolvido para estoque!',
                timer: 1900
            })
        </script>
    @endif
    @if (session()->exists('atualizacao-success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Lab atualizado!',
                timer: 1900
            })
        </script>
    @endif
    @if (session()->exists('bemmovel-success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Item inserido!',
                timer: 1900
            })

            //abrir na aba de bens moveis
            var firstTabEl = document.querySelector('#myTab li:last-child a')
            var firstTab = new bootstrap.Tab(firstTabEl)
            firstTab.show()
        </script>
    @endif
    @if (session()->exists('InsumosEquipamentos-success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Item inserido!',
                timer: 1900
            })

            //abrir na aba de bens moveis
            var firstTabEl = document.querySelector('#myTab li:nth-child(2) a')
            var firstTab = new bootstrap.Tab(firstTabEl)
            firstTab.show()
        </script>
    @endif

    @if (session()->exists('recebimento-success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Item(ns) inserido(s)!',
                timer: 1900
            })

            //abrir na aba de bens moveis
            var firstTabEl = document.querySelector('#myTab li:nth-child(4) a')
            var firstTab = new bootstrap.Tab(firstTabEl)
            firstTab.show()
        </script>
    @endif


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
