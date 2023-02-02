@extends('master')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">SisLab</h1>




    <div class="row">



        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Quantidade de laboratórios por IP</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body" style="padding-bottom: 20px; padding-left: 5px; padding-right: 5px">
                    <div id="columnchart_values" class="chart"></div>
                </div>
            </div>
        </div>


        <!-- Area Chart -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Quantidade de Laboratórios por componente</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body" style="padding-bottom: 20px; padding-left: 5px; padding-right: 5px">
                    <div id="donutchart" class="chart"></div>
                </div>
            </div>
        </div>


        <!-- Area Chart -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Quantidade de Usuários</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body" style="padding-bottom: 20px; padding-left: 5px; padding-right: 5px">
                    <div id="barchart_values" class="chart"></div>
                </div>
            </div>
        </div>


    </div>
@endsection



@section('js')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", {
            packages: ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ["Element", "Laboratórios", {
                    role: "style"
                }],


                @php
                    foreach ($iemasLabQnt as $key => $item) {
                        echo "['$item->nome',$item->count,  $item->count <= 1 ? '#DC3912':'#4E73DF'],";
                    }
                @endphp

            ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                {
                    calc: "stringify",
                    sourceColumn: 1,
                    type: "string",
                    role: "annotation"
                },
                2
            ]);

            var options = {
                // title: "Density of Precious Metals, in g/cm^3",
                fontSize: 10,
                bar: {
                    groupWidth: "95%"
                },
                legend: {
                    position: "none"
                },
                chartArea: {
                    top: 20,
                    left: 85,
                    right: 20,
                }
            };
            var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
            chart.draw(view, options);
        }
        $(window).resize(function() {
            drawChart();

        });
    </script>
    <script type="text/javascript">
        google.charts.load("current", {
            packages: ["corechart"]
        });
        google.charts.setOnLoadCallback(drawChart2);

        function drawChart2() {

            var data = google.visualization.arrayToDataTable([

                @php
                    echo "['Task', 'Hours per Day'],";
                    foreach ($labComponentesQnt as $key => $item) {
                        echo "['$item->componente',$item->count],";
                    }

                @endphp

            ]);


            var options = {
                // title: 'My Daily Activities',
                pieHole: 0.6,
                legend: 'bottom',
                chartArea: {
                    top: 10,
                }
            };

            var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
            chart.draw(data, options);
        }
        $(window).resize(function() {
            drawChart2();

        });
    </script>

    <script type="text/javascript">
        google.charts.load("current", {
            packages: ["corechart"]
        });
        google.charts.setOnLoadCallback(drawChart3);

        function drawChart3() {
            var data = google.visualization.arrayToDataTable([
                ["Element", "Quantidade", {
                    role: "style"
                }],

                @php
                    // echo "['$item->nome',$item->count,  $item->count <= 1 ? '#E74A3B':'#5973E1'],";
                    echo '["' . $usuariosQnt[0]->perfil . '",' . $usuariosQnt[0]->count . ',"' . '#1CC88A' . '"],';
                    echo '["' . $usuariosQnt[1]->perfil . '",' . $usuariosQnt[1]->count . ',"' . '#36B9CC' . '"],';
                    echo '["' . $usuariosQnt[2]->perfil . '",' . $usuariosQnt[2]->count . ',"' . '#4E73DF' . '"],';
                @endphp


            ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                {
                    calc: "stringify",
                    sourceColumn: 1,
                    type: "string",
                    role: "annotation"
                },
                2
            ]);

            var options = {
                // title: "Density of Precious Metals, in g/cm^3",

                bar: {
                    groupWidth: "95%"
                },
                legend: {
                    position: "none"
                },
                chartArea: {
                    top: 50,
                }
            };
            var chart = new google.visualization.BarChart(document.getElementById("barchart_values"));
            chart.draw(view, options);
        }
        $(window).resize(function() {
            drawChart3();

        });
    </script>
@endsection
