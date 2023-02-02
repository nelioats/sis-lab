@extends('master')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-3 text-gray-800">Adicione Itens da Nota - {{$notaFiscal->nota_fiscal_numero}}</h1>
    <p class="mb-3">Adicione todos itens existentes na nota.</p>


    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('listNotas') }}">Listar</a></li>
            <li class="breadcrumb-item active" aria-current="page">Nota</li>
        </ol>
    </nav>

    <div class="row">

        <div class="col-xl-12 col-lg-12 card shadow pb-4 pt-3 mb-3">

            <form action="{{route('salvarItensNota')}}" method="post" class="p-2">
                @csrf

                <div id="item_form_add">

                    <div class="form-group col-md-1" hidden>
                        <input type="text" name="comprasnota_id" value="{{$notaFiscal->id}}" class="form-control" required>
                        <input type="text" name="nota_fiscal_numero" value="{{$notaFiscal->nota_fiscal_numero}}" class="form-control" required>
                    </div>

                    <div class="form-row mb-3">

                        <div class="form-group col-md-4">
                            <label>Item:</label>
                            <select class="form-control" name="itemCatalogo_id[]" required>
                                <option></option>
                                @foreach ($itensCatalogo as $item)
                                    <option value="{{ $item->id }}">{{ $item->nome }}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="form-group col-md-1">
                            <label>Qnt:</label>
                            <input type="number" name="quantidadeItem[]" id="quantidadeItem" onchange="multiplicaSimples()" class="form-control" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label>Valor Und(R$):</label>
                            <input type="text" name="valorUndItem[]" id="valorUndItem" onchange="multiplicaSimples()" class="form-control valor" required placeholder="000.000,00">
                        </div>

                        <div class="form-group col-md-3">
                            <label>Valor Total(R$):</label>
                            <input type="text" name="valorTotalItem[]" id="valorTotalItem" class="form-control valor" required placeholder="000.000,00" readonly>
                        </div>

                    </div>

                </div>

                <div class="mb-4">
                    <button class="btn btn-success btn-icon-split" type="button" onclick="adicionarItem()">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Adicionar item da nota</span>
                    </button>
                </div>
                <hr>


                <button type="submit" class="btn mt-2 btn-primary">Gravar Item(ns) na nota</button>

            </form>

        </div>

    </div>


    {{-- RESUMO NOTA --}}

    <div class="row">

        <div class="col-xl-12 col-lg-12 card shadow pb-5 pt-3 mb-3">

            <table id="exampleData" style="font-size: 0.9rem" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th class="text-center">Código</th>
                        <th class="text-center">Nome</th>
                        <th class="text-center">Quantidade</th>
                        <th class="text-center">Valor Unitário</th>
                        <th class="text-center">Valor Total</th>
                        <th class="text-center">Excluir</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($notaFiscal->ComprasNotasItens as $item)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td class="text-center">{{ $item->codCompraItem }}</td>
                            <td class="text-center">{{ $item->Catalogo->nome }}</td>
                            <td class="text-center">{{ $item->quantidadeItem }}</td>
                            <td class="text-right">{{ $item->valorUndItem }}</td>
                            <td class="text-right">{{ $item->valorTotalItem }}</td>
                            <td class="text-center"> <a href="{{route('destroyItensNota',['codCompraItem' => $item->codCompraItem])}}"><i
                                class='far fa-trash-alt'></i></a></td>
                        </tr>



                    @endforeach

                </tbody>
                <tfoot style="background-color: rgb(223, 223, 223)">
                    <tr>
                      <td><strong>Total</strong></td>
                      <td colspan="5" class="text-right">{{$notaFiscal->valor_total_nota}}</td>
                      <td></td>
                    </tr>
                  </tfoot>

            </table>


            <div class="col-xl-4">
                <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#destroyNOTAModal">
                    Excluir nota
                </a>
            </div>


        </div>

    </div>




    <!-- Destroy NOTA Modal-->
    <div class="modal fade" id="destroyNOTAModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deseja excluir Nota?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Clique em "Excluir" para remover de forma definitiva a nota e seus itens.
                    <p style="color: red">* Os itens também serão elimandos do estoque.</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary"
                        href="{{ route('destroyNota', ['notaFiscal_id' => $notaFiscal->id]) }}">Excluir</a>
                </div>
            </div>
        </div>
    </div>



@endsection


@section('js')
    <script>

        function multiplicaSimples(){

            var quantidadeItem = document.querySelector('#quantidadeItem').value;
            console.log('quantidadeItem = '+ quantidadeItem);

            var valorUndItem =  document.querySelector('#valorUndItem').value;
            var valorUndItemFormat = (valorUndItem.replace(".","")).replace(",",".");

            console.log('valorUndItem = '+ valorUndItemFormat);

            var valorTotalItem = (quantidadeItem * valorUndItemFormat);
            console.log('valorTotalItem = '+ valorTotalItem.toLocaleString('pt-br', {minimumFractionDigits: 2}));

            document.querySelector('#valorTotalItem').value = valorTotalItem.toLocaleString('pt-br', {minimumFractionDigits: 2});
        }


        function multiplica(controleCampo){

                console.log(controleCampo);



            var quantidadeItem = document.querySelector('#quantidadeItem' + controleCampo +'').value;
            console.log('quantidadeItem = '+ quantidadeItem);

            var valorUndItem =  document.querySelector('#valorUndItem' + controleCampo +'').value;
            var valorUndItemFormat = (valorUndItem.replace(".","")).replace(",",".");

            console.log('valorUndItem = '+ valorUndItemFormat);

            var valorTotalItem = (quantidadeItem * valorUndItemFormat);
            console.log('valorTotalItem = '+ valorTotalItem.toLocaleString('pt-br', {minimumFractionDigits: 2}));

            document.querySelector('#valorTotalItem' + controleCampo +'').value = valorTotalItem.toLocaleString('pt-br', {minimumFractionDigits: 2});






        }

        var controleCampo = 1;

        function adicionarItem() {
            controleCampo++;
            console.log(controleCampo);

            document.getElementById('item_form_add').insertAdjacentHTML('beforeend',
                '<div class = "form-row mb-3" id="campo' + controleCampo +'"><div class="form-group col-md-4"> <label>Item:</label>  <select class="form-control" name="itemCatalogo_id[]" required><option></option>@foreach ($itensCatalogo as $item)  <option value="{{ $item->id }}">{{ $item->nome }}</option>@endforeach </select> </div> <div class="form-group col-md-1"><label>Qnt:</label><input type="number" name="quantidadeItem[]" id="quantidadeItem' + controleCampo +'" onchange="multiplica(' + controleCampo +')" class="form-control" required></div>  <div class="form-group col-md-3">    <label>Valor Und(R$):</label> <input type="text" name="valorUndItem[]" id="valorUndItem' + controleCampo +'" onchange="multiplica(' + controleCampo +')" class="form-control valor" required placeholder="000.000,00">  </div> <div class="form-group col-md-3">  <label>Valor (R$):</label><input type="text" name="valorTotalItem[]" id="valorTotalItem' + controleCampo +'" class="form-control valor" required placeholder="000.000,00" readonly></div>  <div class="form-group col-md-1 pt-20" style="padding-top: 20px;"> <button type="button" id="'+controleCampo+'" onclick="removerCampo('+controleCampo+')" class="btn btn-danger btn-circle">  <i class="fas fa-trash"></i>  </button></div> </div>')


            $(document).ready(function() {
            $(".valor").mask("000.000,00", {
                reverse: true
            });
            $(".cpf").mask("000.000.000-00");
            $(".telefone").mask("(99) 99999-9999");
            $(".date").mask("00/00/0000");
        });
        }
        function removerCampo(idCampo){
            document.getElementById('campo' + idCampo).remove()
        }
    </script>
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
      @if (session()->exists('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Item(ns) adicionado(s)!',
                timer: 1900
            })
        </script>
      @endif
      @if (session()->exists('delete-success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Item removido!',
                timer: 1900
            })
        </script>
      @endif
@endsection
