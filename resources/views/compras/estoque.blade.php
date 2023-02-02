@extends('master')
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-3 text-gray-800">Estoque</h1>
    <p class="mb-3">Clique no <span class="btn btn-success btn-circle btn-sm"><i class="fa fa-plus"></i></span> para preparar
        seu envio.</p>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('listNotas') }}">Listar Notas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Estoque</li>
        </ol>
    </nav>

    <div class="row">

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="insumo-tab" data-toggle="tab" href="#insumo" role="tab"
                    aria-controls="insumo" aria-selected="true">Estoque</a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#equipamento" role="tab"
                    aria-controls="profile" aria-selected="false">Equipamento</a>
            </li> --}}

        </ul>

    </div>


    <div class="row">

        <div class="col-xl-12 col-lg-12 card shadow pb-5 pt-3 mb-3">


            <div class="tab-content" id="myTabContent">

                {{-- INSUMOS --}}
                <div class="tab-pane fade show active" id="insumo" role="tabpanel" aria-labelledby="insumo-tab">

                    <table id="exampleData" style="font-size: 0.9rem" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Código Item Nota</th>
                                <th class="text-center">natureza</th>
                                <th class="text-center">Descrição</th>
                                <th class="text-center">Qnt disponível</th>
                                <th class="text-center">Qnt enviar</th>
                                <th class="text-center">Enviar</th>

                            </tr>
                        </thead>
                        <tbody id="tbodyEstoqueInsumo">

                            @foreach ($estoqueGeral as $estoque)
                                <tr>
                                    <td class="text-center align-middle">{{ $loop->index + 1 }}</td>
                                    <td class="text-center align-middle">{{ $estoque->codCompraItem }}</td>
                                    <td class="text-center align-middle">{{ $estoque->natureza }}</td>
                                    <td class="text-center align-middle">{{ $estoque->nome }}</td>
                                    <td id="qnt_insumo{{ $loop->index + 1 }}" class="text-center align-middle">
                                        {{ $estoque->quantidadeItem }}</td>
                                    <td><input id="insumo{{ $loop->index + 1 }}" onchange="verificaMaximo(this)"
                                            type="number" name="" value="" class="form-control align-middle"
                                            min="1" max="{{ $estoque->quantidadeItem }}"></td>
                                    <td class="text-center" estoqueIdLoop="insumo{{ $loop->index + 1 }}"
                                        estoqueId="{{ $estoque->id }}"
                                        estoqueComprasnota_id="{{ $estoque->comprasnota_id }}"
                                        estoqueItemCatalogo_id="{{ $estoque->itemCatalogo_id }}"
                                        estoqueCodCompraItem="{{ $estoque->codCompraItem }}"
                                        estoqueItemNome="{{ $estoque->nome }}"
                                        estoqueQuantidadeItem="{{ $estoque->quantidadeItem }}"
                                        estoqueValorUndItem="{{ $estoque->valorUndItem }}" onclick="prepararEnvio(this)">
                                        <button class="btn btn-success btn-circle btn-sm">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </td>

                                </tr>
                            @endforeach


                        </tbody>
                    </table>



                </div>



                {{-- EQUIPAMENTOS --}}
                {{-- <div class="tab-pane
                        fade" id="equipamento" role="tabpanel"
                    aria-labelledby="profile-tab">

                    <table id="exampleData2" style="font-size: 0.9rem" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-center">Código</th>
                                <th class="text-center">Descrição</th>
                                <th class="text-center">Quantidade</th>
                                <th class="text-center">Enviar</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($estoqueEquipamento as $estoque)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td class="text-center">{{ $estoque->codCompraItem }}</td>
                                    <td class="text-center">{{ $estoque->nome }}</td>
                                    <td class="text-center">{{ $estoque->quantidadeItem }}</td>
                                    <td class="text-center" estoqueId="{{ $estoque->id }}"
                                        estoqueComprasnota_id="{{ $estoque->comprasnota_id }}"
                                        estoqueItemCatalogo_id="{{ $estoque->itemCatalogo_id }}"
                                        estoqueCodCompraItem="{{ $estoque->codCompraItem }}"
                                        estoqueItemNome="{{ $estoque->nome }}"
                                        estoqueQuantidadeItem="{{ $estoque->quantidadeItem }}"
                                        estoqueValorUndItem="{{ $estoque->valorUndItem }}" onclick="receberDados(this)">
                                        <a href="#" class="btn btn-success btn-circle btn-sm" data-toggle="modal"
                                            data-target="#exampleModal">
                                            <i class="fas fa-truck"></i>
                                        </a>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div> --}}

            </div>



        </div>

    </div>

    <!----------------------- RESUMO DE PEDIDOS  -------------------------->
    <div id="resumo" hidden>

        <p class="h3 mb-3 mt-5 text-gray-800">Resumo da ordem de envio</p>



        <div class="row">
            <div class="col-sm-8 card shadow mb-4">

                <table class="table mt-3" id="tableResumoId">
                    <thead>
                        <tr class="table-active">
                            <th class="text-center" scope="col">#</th>
                            <th class="text-center" scope="col">Cod Produto</th>
                            <th class="text-center" scope="col">Descrição</th>
                            <th class="text-center" scope="col">Qnt</th>
                            <th class="text-center" scope="col">Remover</th>
                        </tr>
                    </thead>
                    <tbody>



                    </tbody>
                </table>

            </div>
            <div class="col-sm-4 card shadow mb-4">

                <table class="table mt-3" id="tableResumoUnidadeLab">
                    <tr style="background-color: #DADADA">
                        <th scope="col">IEMA Pleno:</th>
                    </tr>
                    <tr>
                        <th scope="row">

                            <select id="unidade_id" class="form-control" name="estoque_unidade_id"
                                onchange="unidade_Selecionado()" required>
                                <option></option>
                                @foreach ($unidades as $unidade)
                                    <option value="{{ $unidade->id }}">{{ $unidade->nome }}
                                    </option>
                                @endforeach
                            </select>

                        </th>
                    </tr>
                    <tr style="background-color: #DADADA">
                        <th scope="row">Laboratório:</th>
                    </tr>
                    <tr>
                        <th scope="row">
                            <select class="form-control" id="laboratorioId" name="estoque_laboratorio_id" required>
                                <option></option>
                            </select>
                        </th>
                    </tr>
                    <tr style="background-color: #DADADA">
                        <th scope="row">Número de CI/OD:</th>
                    </tr>
                    <tr>
                        <th scope="row">
                            <input type="text" name="" value="" id="numDocumento" class="form-control"
                                required>
                        </th>
                    </tr>
                    <tr style="background-color: #DADADA">
                        <th scope="row">Data de envio:</th>
                    </tr>
                    <tr>
                        <th scope="row">
                            <input type="date" name="" value="" id="dataEnvio" class="form-control">
                        </th>
                    </tr>
                    <tr style="background-color: #DADADA">
                        <th scope="row">Responsável pelo envio:</th>
                    </tr>
                    <tr>
                        <th scope="row">
                            <select class="form-control" id="responsavelEnvio" name="estoque_responsavelEnvio" required>
                                <option></option>
                                @foreach ($usuariosAdm as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach

                            </select>
                        </th>
                    </tr>
                    <tr>
                        <th scope="row">
                            <button type="submit" class="btn btn-primary btn-lg btn-block" data-toggle="modal"
                                data-target="#confirmarEnvioItens">Enviar item(ns)</button>
                        </th>
                    </tr>
                </table>

            </div>
        </div>

        {{-- <table class="table" id="tableResumoId">
            <thead>
                <tr>
                    <th class="text-center" scope="col">#</th>
                    <th class="text-center" scope="col">Cod Produto</th>
                    <th class="text-center" scope="col">Descrição</th>
                    <th class="text-center" scope="col">Qnt</th>
                    <th class="text-center" scope="col">Remover</th>
                </tr>
            </thead>
            <tbody>



            </tbody>
        </table> --}}





    </div>

    <!----------------------- Modal  -------------------------->


    {{-- modal para confirmação de envio --}}

    <div class="modal fade" id="confirmarEnvioItens" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirma envio dos itens?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Clique em "Enviar" para prosseguir com envio dos itens.

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary" onclick="submitDados()" data-dismiss="modal">Enviar</a>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal forma antiga de envio -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong style="color: red">Quantidade disponível: <span
                                id="Modal_EstoqueQuantidadeItem"></span></strong>
                    </p>
                    <p><strong>Enviar para:</strong></p>
                    <form action="{{ route('estoque_envia_laboratorio') }}" method="post">
                        @csrf


                        <input type="text" id="Modal_EstoqueId" value="" name="estoque_Id" hidden>
                        <input type="text" id="Modal_EstoqueComprasnota_id" value=""
                            name="estoque_comprasnota_id" hidden>
                        <input type="text" id="Modal_EstoqueItemCatalogo_id" value=""
                            name="estoque_itemCatalogo_id" hidden>
                        <input type="text" id="Modal_EstoqueCodCompraItem" value=""
                            name="estoque_codCompraItem" hidden>
                        <input type="text" id="Modal_EstoqueQuantidadeItemInput" value=""
                            name="estoque_quantidadeItem" hidden>
                        <input type="text" id="Modal_EstoqueValorUndItem" value="" name="estoque_valorUndItem"
                            hidden>

                        <div class="form-group">
                            <label>IEMA Pleno:</label>
                            <select id="unidade_id" class="form-control" name="estoque_unidade_id"
                                onchange="unidade_Selecionado()" required>
                                <option></option>
                                @foreach ($unidades as $unidade)
                                    <option value="{{ $unidade->id }}">{{ $unidade->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mt-3">
                            <label>Selecione o Laboratório:</label>
                            <select class="form-control" id="laboratorioId" name="estoque_laboratorio_id" required>
                                <option></option>
                            </select>
                        </div>


                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label>Informe a quantidade:</label>
                                <div class="form-group pl-0  border-bottom">
                                    <input id="Modal_EstoqueQuantidadeItem_Max" type="number"
                                        name="estoque_quantidadeSolicitada" class="form-control" min="1"
                                        max="" required>
                                </div>
                            </div>
                            <div class="form-group col-md-7">
                                <label class="">Data de envio:</label>
                                <div class="form-group pl-0 border-bottom">
                                    <input type="date" id="Modal_DataEnvioItem" name="estoque_dataEnvioItem"
                                        class="form-control" required>
                                </div>
                            </div>

                        </div>




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

    {{-- FIM MODAL --}}
@endsection


@section('js')
    <script>
        let itens = [];
        let key_id = 1;

        function verificaMaximo(dados) {

            let valorRecebido = parseInt(dados.value);
            let valorMaximo = parseInt(dados.max);


            let restante = valorMaximo - valorRecebido;
            document.getElementById('qnt_' + dados.id).innerHTML = restante;



            if (valorRecebido > valorMaximo) {
                dados.value = dados.max
            }
        }

        function prepararEnvio(dados) {

            //verificando se input esta em branco
            let inputId = dados.getAttribute('estoqueIdLoop');
            let valorId = document.getElementById(inputId);
            if (valorId.value === "") {
                valorId.setAttribute("placeholder", "campo obrigatório");
            } else {

                let estoqueId = dados.getAttribute('estoqueId')
                let estoqueItemCatalogo_id = dados.getAttribute('estoqueItemCatalogo_id')
                let estoqueItemNome = dados.getAttribute('estoqueItemNome');
                let estoqueQuantidadeItem = valorId.value;


                let item = {
                    id: key_id,
                    estoqueId: estoqueId,
                    itemCatalogo_id: estoqueItemCatalogo_id,
                    itemCatalogo_id: estoqueItemCatalogo_id,
                    itemNome: estoqueItemNome,
                    quantidadeItem: estoqueQuantidadeItem
                };

                itens.push(item);


                //apresentado html com listagem
                if (itens.length > 0) {
                    let blocoResumo = document.querySelector('#resumo');
                    blocoResumo.removeAttribute("hidden")

                    let table = document.querySelector('#tableResumoId');

                    let row = document.createElement("tr");
                    row.setAttribute("id", 'LinhaResumoId' + key_id)
                    let idLinha = row.getAttribute('id');

                    //console.log(idLinha);

                    let cel1 = document.createElement("td");
                    let cel2 = document.createElement("td");
                    let cel3 = document.createElement("td");
                    let cel4 = document.createElement("td");
                    let cel5 = document.createElement("td");

                    cel1.classList.add('text-center');
                    cel2.classList.add('text-center');
                    cel3.classList.add('text-center');
                    cel4.classList.add('text-center');
                    cel5.classList.add('text-center');

                    cel1.innerHTML = itens.length;
                    cel2.innerHTML = itens[itens.length - 1].itemCatalogo_id;
                    cel3.innerHTML = itens[itens.length - 1].itemNome;
                    cel4.innerHTML = itens[itens.length - 1].quantidadeItem;
                    cel5.innerHTML =
                        '<button class="btn btn-danger btn-circle btn-sm" onclick="excluiItem(' + idLinha + ',' + inputId +
                        ',' + itens[itens.length - 1].quantidadeItem +
                        ')"><i class="fa fa-times" aria-hidden="true"></i></button>';

                    row.appendChild(cel1);
                    row.appendChild(cel2);
                    row.appendChild(cel3);
                    row.appendChild(cel4);
                    row.appendChild(cel5);

                    table.appendChild(row);

                    key_id++;

                } else {
                    blocoResumo.setAttribute("hidden", "hidden")

                }

            }

        }

        function excluiItem(valor, inputId, quantidadeExcluida) {

            let table = document.querySelector('#tableResumoId');
            let removerLinha = document.getElementById(valor.id);
            table.removeChild(removerLinha);

            //console.log(removerLinha.id)
            //pegando valor do id para ser deletado
            let prepareRemoveId = removerLinha.id.match(/\d+/);
            //console.log('Remover id ' + prepareRemoveId[0]);
            let idDeletar = parseInt(prepareRemoveId[0]);
            //console.log(idDeletar)
            //atualizando array
            itens = itens.filter(function(item) {
                return item.id !== idDeletar;
            });

            //limpando campo de Qnt Enviar
            let updateInput = inputId.getAttribute('id');
            document.getElementById(updateInput).value = '';

            //retornando valor para tabela principal
            let valorRestante = document.getElementById('qnt_' + updateInput).innerHTML;
            let retornandoValor = parseInt(valorRestante) + parseInt(quantidadeExcluida);
            document.getElementById('qnt_' + updateInput).innerHTML = retornandoValor;


            if (itens.length == 0) {
                document.querySelector('#resumo').setAttribute("hidden", "hidden");
            }

            //reordenando o sequencial de numeros
            let caputrandoTds = document.querySelectorAll('#tableResumoId tr td:first-child')

            for (let i = 0; i < caputrandoTds.length; i++) {
                caputrandoTds[i].innerHTML = i + 1;
            }

            //console.log(valor)
            console.log(itens)


        }

        async function submitDados() {


            console.log(itens)

            let unidade_id = document.querySelector('#unidade_id').value;
            let laboratorio_id = document.querySelector('#laboratorioId').value;
            let numDocumento = document.querySelector('#numDocumento').value;
            let dataEnvio = document.querySelector('#dataEnvio').value;
            let responsavelEnvio = document.querySelector('#responsavelEnvio').value;

            console.log(unidade_id, laboratorio_id, numDocumento, dataEnvio, responsavelEnvio)

            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            let url = "{{ route('estoque_envia_laboratorio_pendente') }}";

            await fetch(url, {
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": token
                    },
                    method: 'post',
                    credentials: "same-origin",
                    body: JSON.stringify({
                        itens,
                        unidade_id,
                        laboratorio_id,
                        numDocumento,
                        dataEnvio,
                        responsavelEnvio,
                    })
                })
                .then(response => response.json())
                .then(data =>

                    mensagem(),
                    limparCampos(),


                )
                .catch(error => console.log(error));

        }

        function mensagem() {
            Swal.fire({
                icon: 'success',
                title: 'Item enviado!',
                timer: 1900
            })
        };

        function limparCampos() {
            document.querySelector('#unidade_id').value = '';
            document.querySelector('#laboratorioId').value = '';
            document.querySelector('#numDocumento').value = '';
            document.querySelector('#dataEnvio').value = '';
            document.querySelector('#responsavelEnvio').value = '';

            itens = [];

            //limpar campos da tabela principal
            let table = document.querySelector('#exampleData');
            let inputs = table.querySelectorAll("input")
            for (let i = 0; i < inputs.length; i++) {
                inputs[i].value = '';
            }

            //deletar tabela de resumo
            let tableResumo = document.querySelector('#tableResumoId');
            tableResumo.innerHTML = '';

            if (itens.length == 0) {
                document.querySelector('#resumo').setAttribute("hidden", "hidden");
            }



        };
    </script>

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


        $(document).ready(function() {
            $("#exampleData2").DataTable({
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

    <script>
        function receberDados(componente) {


            //preenchendo
            let estoqueId = componente.getAttribute('estoqueId');
            let estoqueComprasnota_id = componente.getAttribute('estoqueComprasnota_id');
            let estoqueItemCatalogo_id = componente.getAttribute('estoqueItemCatalogo_id');
            let estoqueCodCompraItem = componente.getAttribute('estoqueCodCompraItem');
            let estoqueItemNome = componente.getAttribute('estoqueItemNome');
            let estoqueQuantidadeItem = componente.getAttribute('estoqueQuantidadeItem');
            let estoqueValorUndItem = componente.getAttribute('estoqueValorUndItem');

            document.querySelector("#exampleModalLabel").innerHTML = estoqueItemNome;
            document.querySelector("#Modal_EstoqueId").value = estoqueId;
            document.querySelector("#Modal_EstoqueComprasnota_id").value = estoqueComprasnota_id;
            document.querySelector("#Modal_EstoqueItemCatalogo_id").value = estoqueItemCatalogo_id;
            document.querySelector("#Modal_EstoqueCodCompraItem").value = estoqueCodCompraItem;
            document.querySelector("#Modal_EstoqueQuantidadeItem").innerHTML = estoqueQuantidadeItem;
            document.querySelector("#Modal_EstoqueQuantidadeItemInput").value = estoqueQuantidadeItem;
            document.querySelector("#Modal_EstoqueQuantidadeItem_Max").max = estoqueQuantidadeItem;
            document.querySelector("#Modal_EstoqueValorUndItem").value = estoqueValorUndItem;

        }

        function limpandoCampos() {

            document.querySelector("#Modal_EstoqueQuantidadeItem_Max").value = '';
            document.querySelector("#laboratorioId").innerHTML = '';
            document.querySelector("#Modal_DataEnvioItem").value = '';




        }
    </script>

    <script>
        function unidade_Selecionado() {

            let unidade_id = document.getElementById('unidade_id').value;
            //console.log(unidade_id);
            requisitar(unidade_id);
        }

        async function requisitar(unidade_id) {
            let laboratorios = document.getElementById('laboratorioId');

            let url = "{{ route('estoque_list_laboratorios', ['id' => ':id']) }}";
            url = url.replace(":id", unidade_id);

            let selectCriados = '';

            await fetch(url)
                .then(response => response.json())
                .then(resultado => {

                    resultado.map((indice) => {
                        selectCriados += "<option value=" + indice.id + ">" + indice.prefixo + "</option>";
                    })
                    laboratorios.innerHTML = selectCriados;
                })

        }
    </script>

    @if (session()->exists('envio-success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Item enviado!',
                timer: 1900
            })
        </script>
    @endif
@endsection
