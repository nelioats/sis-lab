@extends('master')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $unidade->nome }}</h1>


    <div class="row">


        <!-- Base Nacional Comum -->
        <div class="col-lg-12">
            <div class="card  mb-2">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Base Nacional Comum</h6>
                </div>
                <div class="card-body pb-1">
                    <div class="row">

                        @foreach ($laboratoriosUnidade as $laboratorio)
                            @if ($laboratorio->base == 'BASE NACIONAL COMUM')
                                <div class="col-xl-3 col-md-6 mb-4">
                                    <div
                                        class="card {{ $loop->index == 0 ? 'border-left-primary' : '' }} {{ $loop->index == 1 ? 'border-left-success' : '' }} {{ $loop->index == 2 ? 'border-left-info' : '' }} {{ $loop->index == 3 ? 'border-left-warning' : '' }} shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="h5 mb-0 font-weight-bold">
                                                        <a style="text-decoration: none;"
                                                            class="{{ $loop->index == 0 ? 'text-primary' : '' }} {{ $loop->index == 1 ? 'text-success' : '' }} {{ $loop->index == 2 ? 'text-info' : '' }} {{ $loop->index == 3 ? 'text-warning' : '' }}"
                                                            href="{{ route('detalheslab', ['id' => $laboratorio->id]) }}">
                                                            {{ $laboratorio->componente->componente }}
                                                        </a>
                                                    </div>
                                                    <div class="text-xs font-weight-bold  text-uppercase mt-1"
                                                        style="{{ $laboratorio->status == 'Parcialmente Instalado' ? 'color: blue; ' : ($laboratorio->status == 'Instalado' ? 'color: rgb(3, 175, 3)' : 'color: red') }}">
                                                        {{ $laboratorio->status }}
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <strong>01</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                    </div>
                </div>
            </div>
        </div>

        <!-- Base Técnica -->
        <div class="col-lg-12">
            <div class="card mb-2">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Base Técnica</h6>
                </div>
                <div class="card-body pb-1">
                    <div class="row">
                        @foreach ($laboratoriosUnidade as $laboratorio)
                            @if ($laboratorio->base == 'BASE TÉCNICA')
                                <div class="col-xl-3 col-md-6 mb-4">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="h5 mb-0 font-weight-bold">
                                                        <a style="text-decoration: none;" class="text-primary"
                                                            href="{{ route('detalheslab', ['id' => $laboratorio->id]) }}">
                                                            {{ $laboratorio->componente->componente }}
                                                        </a>
                                                    </div>
                                                    <div class="text-xs font-weight-bold  text-uppercase mt-1"
                                                        style="{{ $laboratorio->status == 'Parcialmente Instalado' ? 'color: blue; ' : ($laboratorio->status == 'Instalado' ? 'color: rgb(3, 175, 3)' : 'color: red') }}">
                                                        {{ $laboratorio->status }}
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <strong>01</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Laboratórios da IP / Valor Total --}}
    <div class="row">
        <div class="col-lg-12 mb-1">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    Laboratórios da IP / Valor Total
                </div>
            </div>
        </div>
        <div class="col-lg-12 mb-3">


            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cod Laboratório:</th>
                        <th>Data Entrega:</th>
                        <th>Valor Total</th>
                    </tr>
                </thead>
                <tbody>



                    @foreach ($laboratoriosUnidade as $laboratorio)
                        <tr>
                            <th>{{ $loop->index + 1 }}</th>
                            <td>{{ $laboratorio->prefixo }}</td>
                            <td>{{ $laboratorio->data_entrega }}</td>
                            <td>R$ {{ $laboratorio->valorLab_total }}</td>
                        </tr>
                    @endforeach


                    {{-- total --}}
                    <tr>
                        <td colspan="3" class="text-right">Total: </td>
                        <td>R$ {{ $unidade->getValorTotalInvestidoLab($unidade->id) }}
                        </td>
                    </tr>
                </tbody>
            </table>





        </div>
    </div>

    {{-- Insumos e Equipamentos --}}
    <div class="row">
        <div class="col-lg-12 mb-1">
            <div class="card bg-secondary text-white shadow">
                <div class="card-body">
                    Insumos e Equipamentos
                </div>
            </div>
        </div>
        <div class="col-lg-12 mb-3">


            <table class="table table-striped">
                <tbody>

                    <tr>
                        <td scope="col">Quantidade de Insumos:</td>
                        <td scope="col">{{ $unidade->getInsumos($unidade->id)[0] }}</td>

                    </tr>
                    {{-- <tr>
                        <td scope="col">Valor Total de Insumos</td>
                        <td scope="col">R$ {{ $unidade->getInsumos($unidade->id)[1] }}</td>
                    </tr> --}}

                    <tr>
                        <td scope="col">Quantidade de Equipamentos:</td>
                        <td scope="col">{{ $unidade->getEquipamentos($unidade->id)[0] }}</td>

                    </tr>
                    {{-- <tr>
                        <td scope="col">Valor Total de Equipamentos</td>
                        <td scope="col">R$ {{ $unidade->getEquipamentos($unidade->id)[1] }}</td>
                    </tr> --}}

                </tbody>
            </table>





        </div>
    </div>

    {{-- VALOR GASTO PELA IP --}}
    <div class="row">
        <div class="col-lg-12 mb-1">
            <div class="card bg-light text-white shadow">
                <div class="card-body text-center" style="color: rgb(73, 73, 73)">
                    <strong>Valor total Investido na IP:
                        {{ number_format(
                            floatval(str_replace(',', '.', str_replace('.', '', $unidade->getValorTotalInvestidoLab($unidade->id)))) +
                                floatval(str_replace(',', '.', str_replace('.', '', $unidade->getInsumos($unidade->id)[1]))) +
                                floatval(str_replace(',', '.', str_replace('.', '', $unidade->getEquipamentos($unidade->id)[1]))),
                            2,
                            ',',
                            '.',
                        ) }}</strong>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    {{-- <script src="{{ url(asset('js/jquery.mask.min.js')) }}"></script>
    <script>
        $(document).ready(function() {
            $(".valor").mask("000.000,00", {
                reverse: true
            });
            $(".cpf").mask("000.000.000-00");
            $(".telefone").mask("(99) 99999-9999");
            $(".date").mask("00/00/0000");
        });
    </script> --}}
    {{-- @if (session()->exists('data-success'))
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
    @endif --}}
@endsection
