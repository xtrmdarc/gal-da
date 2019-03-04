@extends('layouts.application.master')

@section('content')

        @php
        date_default_timezone_set('America/Lima');
        setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
        $fecha = date("d-m-Y h:i A");
        $fechaa = date("d-m-Y 12:00 ");

        @endphp

        <input type="hidden" id="moneda" value="{{session('moneda')}}"/>

                <div class="wrapper wrapper-content animated shake">
                        <div class="ibox">
                                <div class="ibox-title">
                                        <div class="row">
                                                <div class="col-sm-12">
                                                        <h3   style="margin-bottom: 10px;">Resumen de Ventas</h3>
                                                </div>
                                        </div>
                                        <div class="row" style="margin-top:20px;">
                                                
                                                <div class="col-sm-4">
                                                        <div class="form-group">
                                                                <div class="input-group">
                                                                        <input type="text" class="form-control bg-r" name="start" id="start" value="<?php echo $fechaa,' AM'; ?>" disabled/>
                                                                        <span class="input-group-addon">al</span>
                                                                        <input type="text" class="form-control bg-r" name="end" id="end" value="<?php echo $fecha; ?>" disabled/>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                                <div class="row">
                                        <div class="col-md-4">
                                                <div class="card p-30">
                                                        <div class="media">
                                                                <div class="media-left meida media-middle">
                                                                        <span><i class="fa fa-money f-s-40 color-primary"></i></span>
                                                                </div>
                                                                <div class="media-body media-text-right">
                                                                        <h2 id="totalVentasI">{{$total_venta}}</h2>
                                                                        <p class="m-b-0">Total Ingresos</p>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                                <div class="card p-30">
                                                        <div class="media">
                                                                <div class="media-left meida media-middle">
                                                                        <span><i class="fa fa-shopping-cart f-s-40 color-success"></i></span>
                                                                </div>
                                                                <div class="media-body media-text-right">
                                                                        <h2 id="nVentasI">{{$total_n_venta}}</h2>
                                                                        <p class="m-b-0">Ventas</p>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                                <div class="card p-30">
                                                        <div class="media">
                                                                <div class="media-left meida media-middle">
                                                                        <span><i class="fa fa-user f-s-40 color-danger"></i></span>
                                                                </div>
                                                                <div class="media-body media-text-right">
                                                                        <h2 id="nClientesI">{{$n_clientes}}</h2>
                                                                        <p class="m-b-0">Clientes</p>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                                <div class="row" >
                                        <div id="container" style="width: 100%;
                                                                              height: 500px;
                                                                              margin: 0;
                                                                              padding: 0;">

                                        </div>
                                </div>
                                <input  id="nVentas_g" type="hidden" value="">
                                <input  id="nTotal_g" type="hidden" value="">
                        </div>
                </div>
        </div>

        <div class="modal inmodal fade" id="detalle" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
                <div class="modal-dialog">
                        <div class="modal-content animated bounceInRight">
                                <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                                        <h5 class="modal-title title-d" style="font-size: 18px">Detalle</h5>
                                </div>
                                <div class="modal-body">
                                        <div class="table-responsive">
                                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                                <table class="table table-hover table-condensed table-striped">
                                                        <thead>
                                                        <tr>
                                                                <th>Cantidad</th>
                                                                <th>Producto</th>
                                                                <th>P.U.</th>
                                                                <th class="text-right">Total</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="lista_p"></tbody>
                                                </table>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                                </div>
                                </form>
                        </div>
                </div>
        </div>
        
        <div class="modal inmodal fade" id="mdl-feedback" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
                <div class="modal-dialog">
                        <div class="modal-content animated bounceInRight">
                        <form id="frm-feedback" class="unif_modal" method="post" enctype="multipart/form-data" action="/EnviarFeedback">
                        @csrf
                        <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                                <h4 class="modal-title">Apreciamos tu opinión</h4>
                        </div>
                        <div class="modal-body">
                
                                <div class="row">
                                <div class="col-sm-12">
                                        <p>
                                        ¡Hola, gracias por usar Galda! Nos gustaría conocer tu opinión <b>¿Tienes sugerencias o preguntas?</b> 
                                        Las tomaremos en cuenta para brindarte una mejor experiencia
                                        </p>
                                </div>
                                <div class="col-sm-12">
                                        <div class="form-group">
                                        <label>Comentario:</label>
                                        <textarea name="comentario" class="form-control" style="height:100px" placeholder="Ingrese comentario" autocomplete="off" rows="5" text=""> </textarea>
                                        </div>
                                </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary" ><i class="fa fa-sign-in"></i> Enviar </button>
                        </div>
                        </form>
                        </div>
                </div>
        </div>
        <div class="modal inmodal" id="mdl-video-o" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
                <div class="modal-dialog modal-sm" style="max-width: 900px;">
                        <div class="modal-content animated bounceInRight">
                        <div class="unif_modal">
                                <div class="modal-body" style="background: none!important; padding: 0rem!important;">
                                <div class="row">
                                        <div class="col-sm-12">
                                        <div class="iframe-container">
                                                <div style="width:100%;height:0px;position:relative;padding-bottom:56.250%;"><iframe width="560" height="315" src="https://www.youtube.com/embed/bjCSmPyLbBQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
                                        </div>
                                        </div>
                                </div>
                                </div>
                        </div>
                        </div>
                </div>
        </div>       

@endsection('content')
@section('scripts')
<script src="{{URL::to('rest/scripts/tablero_f/func_tablero_f.js')}}"></script>
<script type="text/javascript">

        anychart.onDocumentReady(function () {
                getData();
        });

        function graficoTableroF(dataSetT){
                // create data set on our data
                var dataSet = anychart.data.set(dataSetT);

                // map data for the first series, take x from the zero column and value from the first column of data set
                var seriesData_1 = dataSet.mapAs({'x': 0, 'value': 1});

                // map data for the second series, take x from the zero column and value from the second column of data set
                var seriesData_2 = dataSet.mapAs({'x': 0, 'value': 2});

                // map data for the third series, take x from the zero column and value from the third column of data set
                var seriesData_3 = dataSet.mapAs({'x': 0, 'value': 3});

                // create line chart
                var chart = anychart.line();

                // turn on chart animation
                chart.animation(true);

                // set chart padding
                chart.padding([10, 20, 5, 20]);

                // turn on the crosshair
                chart.crosshair()
                        .enabled(true)
                        .yLabel(false)
                        .yStroke(null);

                // set tooltip mode to point
                chart.tooltip().positionMode('point');

                // set chart title text settings
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth()+1; //January is 0!
                var yyyy = today.getFullYear();

                if(dd<10) {
                        dd = '0'+dd
                }

                if(mm<10) {
                        mm = '0'+mm
                }

                today = dd + '/' + mm + '/' + yyyy;

                chart.title('Ventas realizadas el dia de hoy ' + today);

                // set yAxis title
                chart.yAxis().title('Numero de Ventas');
                chart.xAxis().labels().padding(5);

                // create first series with mapped data
                var series_1 = chart.line(seriesData_1);
                series_1.name('Ventas');
                series_1.hovered().markers()
                        .enabled(true)
                        .type('circle')
                        .size(4);
                series_1.tooltip()
                        .position('right')
                        .anchor('left-center')
                        .offsetX(5)
                        .offsetY(5);

                // create second series with mapped data
                var series_2 = chart.line(seriesData_2);
                series_2.name('Monto');
                series_2.hovered().markers()
                        .enabled(true)
                        .type('circle')
                        .size(4);
                series_2.tooltip()
                        .position('right')
                        .anchor('left-center')
                        .offsetX(5)
                        .offsetY(5);

                // turn the legend on
                chart.legend()
                        .enabled(true)
                        .fontSize(13)
                        .padding([0, 0, 10, 0]);

                // set container id for the chart
                chart.container('container');
                // initiate chart drawing
                chart.draw();
        }

        function getData() {

                  var   nVentas = 0,
                        nTotal = 0,
                        nVentas2 = 0,
                        nTotal2 = 0,
                        nVentas3 = 0,
                        nTotal3 = 0,
                        nVentas4 = 0,
                        nTotal4 = 0;

                $.ajax({
                        type: "POST",
                        url: "/graficoVentasyMonto",
                        data: {

                        },
                        dataType: "json",
                        headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(item){
                                var a = [
                                        ['00:00 a.m.', 3.6, 2.3, 2.8, 11.5],
                                        ['01:00 ', 7.1, 4.0, 4.1, 14.1],
                                        ['02:00 ', 7.1, 4.0, 4.1, 14.1],
                                        ['03:00 ', 8.5, 6.2, 5.1, 17.5],
                                        ['04:00 ', 20.0, 11.8, 6.5, 18.9],
                                        ['05:00 ', 10.1, 13.0, 12.5, 20.8],
                                        ['06:00 ', 11.6, 13.9, 18.0, 22.9],
                                        ['07:00 ', 11.6, 13.9, 18.0, 22.9],
                                        ['08:00 ', 11.6, 13.9, 18.0, 22.9],
                                        ['09:00 ', 11.6, 13.9, 18.0, 22.9],
                                        ['10:00 ', 11.6, 13.9, 18.0, 22.9],
                                        ['11:00 ', 11.6, 13.9, 18.0, 22.9],
                                        ['12:00 ', 16.4, 18.0, 21.0, 25.2],
                                        ['13:00 ', 18.0, 23.3, 20.3, 27.0],
                                        ['14:00 ', 13.2, 24.7, 19.2, 26.5],
                                        ['15:00 ', 12.0, 18.0, 14.4, 25.3],
                                        ['16:00 ', 3.2, 15.1, 9.2, 23.4],
                                        ['17:00 ', 4.1, 11.3, 5.9, 19.5],
                                        ['18:00 ', 6.3, 14.2, 5.2, 17.8],
                                        ['19:00 ', 6.3, 14.2, 5.2, 17.8],
                                        ['20:00 ', 6.3, 14.2, 5.2, 17.8],
                                        ['21:00 ', 6.3, 14.2, 5.2, 17.8],
                                        ['22:00 ', 6.3, 14.2, 5.2, 17.8],
                                        ['23:59 ', 6.3, 14.2, 5.2, 17.8]
                                ];
                                for(var i = 0; i < item.data.length; i++) {

                                        var f1v = item.data[0].NVentas;
                                        var f1T = item.data[0].Total;

                                        var f2v = item.data[1].NVentas;
                                        var f2T = item.data[1].Total;

                                        var f3v = item.data[2].NVentas;
                                        var f3T = item.data[2].Total;

                                        var f4v = item.data[3].NVentas;
                                        var f4T = item.data[3].Total;

                                        var f5v = item.data[4].NVentas;
                                        var f5T = item.data[4].Total;

                                        var f6v = item.data[5].NVentas;
                                        var f6T = item.data[5].Total;

                                        var f7v = item.data[6].NVentas;
                                        var f7T = item.data[6].Total;

                                        var f8v = item.data[7].NVentas;
                                        var f8T = item.data[7].Total;

                                        var f9v = item.data[8].NVentas;
                                        var f9T = item.data[8].Total;

                                        var f10v = item.data[9].NVentas;
                                        var f10T = item.data[9].Total;

                                        var f11v = item.data[10].NVentas;
                                        var f11T = item.data[10].Total;

                                        var f12v = item.data[11].NVentas;
                                        var f12T = item.data[11].Total;

                                        var f13v = item.data[12].NVentas;
                                        var f13T = item.data[12].Total;

                                        var f14v = item.data[13].NVentas;
                                        var f14T = item.data[13].Total;

                                        var f15v = item.data[14].NVentas;
                                        var f15T = item.data[14].Total;

                                        var f16v = item.data[15].NVentas;
                                        var f16T = item.data[15].Total;

                                        var f17v = item.data[16].NVentas;
                                        var f17T = item.data[16].Total;

                                        var f18v = item.data[17].NVentas;
                                        var f18T = item.data[17].Total;

                                        var f19v = item.data[18].NVentas;
                                        var f19T = item.data[18].Total;

                                        var f20v = item.data[19].NVentas;
                                        var f20T = item.data[19].Total;

                                        var f21v = item.data[20].NVentas;
                                        var f21T = item.data[20].Total;

                                        var f22v = item.data[21].NVentas;
                                        var f22T = item.data[21].Total;

                                        var f23v = item.data[22].NVentas;
                                        var f23T = item.data[22].Total;

                                        var f2359v = item.data[23].NVentas;
                                        var f2359T = item.data[23].Total;

                                        if(f1v == null || f1T == null){
                                                f1v = 0;
                                                f1T = 0;
                                        }
                                        if(f2v == null || f2T == null){
                                                f2v = 0;
                                                f2T = 0;
                                        }
                                        if(f3v == null || f3T == null) {
                                                f3v = 0;
                                                f3T = 0;
                                        }
                                        if(f4v == null || f4T == null) {
                                                f4v = 0;
                                                f4T = 0;
                                        }
                                        if(f5v == null || f5T == null) {
                                                f5v = 0;
                                                f5T = 0;
                                        }
                                        if(f6v == null || f6T == null) {
                                                f6v = 0;
                                                f6T = 0;
                                        }
                                        if(f7v == null || f7T == null) {
                                                f7v = 0;
                                                f7T = 0;
                                        }
                                        if(f8v == null || f8T == null) {
                                                f8v = 0;
                                                f8T = 0;
                                        }
                                        if(f9v == null || f9T == null) {
                                                f9v = 0;
                                                f9T = 0;
                                        }
                                        if(f10v == null || f10T == null) {
                                                f10v = 0;
                                                f10T = 0;
                                        }
                                        if(f11v == null || f11T == null) {
                                                f11v = 0;
                                                f11T = 0;
                                        }
                                        if(f12v == null || f12T == null) {
                                                f12v = 0;
                                                f12T = 0;
                                        }
                                        if(f13v == null || f13T == null) {
                                                f13v = 0;
                                                f13T = 0;
                                        }
                                        if(f14v == null || f14T == null) {
                                                f14v = 0;
                                                f14T = 0;
                                        }
                                        if(f15v == null || f15T == null) {
                                                f15v = 0;
                                                f15T = 0;
                                        }
                                        if(f16v == null || f16T == null) {
                                                f16v = 0;
                                                f16T = 0;
                                        }
                                        if(f17v == null || f17T == null) {
                                                f17v = 0;
                                                f17T = 0;
                                        }
                                        if(f18v == null || f18T == null) {
                                                f18v = 0;
                                                f18T = 0;
                                        }
                                        if(f19v == null || f19T == null) {
                                                f19v = 0;
                                                f19T = 0;
                                        }
                                        if(f20v == null || f20T == null) {
                                                f20v = 0;
                                                f20T = 0;
                                        }
                                        if(f21v == null || f21T == null) {
                                                f21v = 0;
                                                f21T = 0;
                                        }
                                        if(f22v == null || f22T == null) {
                                                f22v = 0;
                                                f22T = 0;
                                        }
                                        if(f23v == null || f23T == null) {
                                                f23v = 0;
                                                f23T = 0;
                                        }
                                        if(f2359v == null || f2359T == null) {
                                                f2359v = 0;
                                                f2359T = 0;
                                        }

                                        a[0][1] = f1v;
                                        a[0][2] = f1T;
                                        a[1][1] = f2v;
                                        a[1][2] = f2T;
                                        a[2][1] = f3v;
                                        a[2][2] = f3T;
                                        a[3][1] = f4v;
                                        a[3][2] = f4T;
                                        a[4][1] = f5v;
                                        a[4][2] = f5T;
                                        a[5][1] = f6v;
                                        a[5][2] = f6T;
                                        a[6][1] = f7v;
                                        a[6][2] = f7T;
                                        a[7][1] = f8v;
                                        a[7][2] = f8T;
                                        a[8][1] = f9v;
                                        a[8][2] = f9T;
                                        a[9][1] = f10v;
                                        a[9][2] = f10T;
                                        a[10][1] = f11v;
                                        a[10][2] = f11T;
                                        a[11][1] = f12v;
                                        a[11][2] = f12T;
                                        a[12][1] = f13v;
                                        a[12][2] = f13T;
                                        a[13][1] = f14v;
                                        a[13][2] = f14T;
                                        a[14][1] = f15v;
                                        a[14][2] = f15T;
                                        a[15][1] = f16v;
                                        a[15][2] = f16T;
                                        a[16][1] = f17v;
                                        a[16][2] = f17T;
                                        a[17][1] = f18v;
                                        a[17][2] = f18T;
                                        a[18][1] = f19v;
                                        a[18][2] = f19T;
                                        a[19][1] = f20v;
                                        a[19][2] = f20T;
                                        a[20][1] = f21v;
                                        a[20][2] = f21T;
                                        a[21][1] = f22v;
                                        a[21][2] = f22T;
                                        a[22][1] = f23v;
                                        a[22][2] = f23T;;
                                        a[23][1] = f2359v;
                                        a[23][2] = f2359T;
                                }
                                graficoTableroF(a);
                        }
                });

        }
</script>
<script type="text/javascript">

        $(function(){
                /*
                const driver = new Driver({
                                        animate: false,
                                        doneBtnText: 'Listo!',              // Text on the final button
                                        closeBtnText: 'Cerrar',            // Text on the close button for this step
                                        stageBackground: '#ffffff',       // Background color for the staged behind highlighted element
                                        nextBtnText: 'Siguiente',              // Next button text for this step
                                        prevBtnText: 'Anterior',
                                        allowClose: false,
                                        onReset : function(element){
                                                $.ajax({
                                                        url: '/UserOnboarded',
                                                        data:'',
                                                        type:'POST',
                                                        dataType: 'json',
                                                        headers: {
                                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                                },
                                                        success: function(){
                                                                console.log('llego');
                                                                drift.SNIPPET_VERSION = '0.3.1';
                                                                drift.load('4i42nk6d6zuw');
                                                        }
                                                });
                                                console.log('llego aqui');

                                        }
                                });
                
                driver.defineSteps([
                        {
                                element:'#sb_configuracion',
                                popover: {
                                        animate: true,
                                        title: 'La información de tu empresa',
                                        description: 'Completa la información de tu empresa antes de utilizar el sistema.',
                                        position:'right'
                                },

                        },
                        {
                                element:'#sb_caja_li',
                                popover: {
                                        animate: true,
                                        title: 'Módulo de Cajas ',
                                        description: 'Utiliza este módulo para aperturar cajas, controlar tus ingresos y egresos.',
                                        position:'right'
                                }
                                
                        },
                        {
                                element:'#sb_clientes_li',
                                popover: {
                                        animate: true,
                                        title: 'Módulo de clientes',
                                        description: 'En este módulo puedes administrar la información de tus clientes.',
                                        position:'right'
                                }
                                
                        },
                        {
                                element:'#sb_tablero_f',
                                popover: {
                                        animate: true,
                                        title: 'Tablero de control',
                                        description: 'Aquí encontrarás el resumen diario de tus ventas.',
                                        position:'right'
                                }
                                
                        },
                        {
                                element:'#sb_pedidos',
                                popover: {
                                        animate: true,
                                        title: 'Módulo de pedidos',
                                        description: 'Realiza y supervisa los pedidos de mesa, mostrador o delivery.',
                                        position:'right'
                                }
                                
                        },
                        {
                                element:'#sb_cocina',
                                popover: {
                                        animate: true,
                                        title: 'Módulo de producción',
                                        description: 'Supervisa los pedidos que llegan a cocina en tiempo real.',
                                        position:'right'
                                }
                                
                        },
                        {
                                element:'#sb_centroayuda',
                                popover: {
                                        animate: true,
                                        title: '¿Necesitas ayuda?',
                                        description: 'Te mostramos paso a paso cómo empezar a utilizar Gal-Da.',
                                        position: 'top'
                                        
                                }       
                        }
                        

                ]);*/
                /*
                        const driver_tut = new Driver({
                                                animate: false,
                                                doneBtnText: 'Listo!',              // Text on the final button
                                                closeBtnText: 'Cerrar',            // Text on the close button for this step
                                                stageBackground: '#ffffff',       // Background color for the staged behind highlighted element
                                                nextBtnText: 'Siguiente',              // Next button text for this step
                                                prevBtnText: 'Anterior',
                                                allowClose: false,
                                                onReset : function(element){
                                                        $.ajax({
                                                                url: '/UserOnboarded',
                                                                data:'',
                                                                type:'POST',
                                                                dataType: 'json',
                                                                headers: {
                                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                                        },
                                                                success: function(){
                                                                        console.log('llego');
                                                                        drift.SNIPPET_VERSION = '0.3.1';
                                                                        drift.load('4i42nk6d6zuw');
                                                                }
                                                        });
                                                        console.log('llego aqui');

                                                }
                                        });
                        
                        driver_tut.defineSteps([
                                {
                                        element:'#tutorial-video',
                                        popover: {
                                                animate: true,
                                                title: 'Video tutorial',
                                                description: 'Puedes volver a acceder al video tutorial aquí',
                                                position: 'left'
                                                
                                        }       
                                }

                        ]); 
                */
                if({{ (Auth::user()->user_onboarded)}} == 0 )
                {
                        //driver.start();
                        fbq('track','StartTrial');
                        $("#mdl-video-o").modal('show');
                        $('#mdl-video-o').on('hidden.bs.modal', function () {
                                // driver_tut.start();
                                $.ajax({
                                        url: '/UserOnboarded',
                                        data:'',
                                        type:'POST',
                                        dataType: 'json',
                                        headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                },
                                        success: function(){
                                                //console.log('llego');
                                                drift.SNIPPET_VERSION = '0.3.1';
                                                drift.load('4i42nk6d6zuw');
                                        }
                                });
                        })
                        
                }
                else{
                        drift.SNIPPET_VERSION = '0.3.1';
                        drift.load('4i42nk6d6zuw');
                }

                if({{ Auth::user()->primer_pedido }} == 1 && {{ Auth::user()->free_feedback_sent  }}== 0 )
                {
                        $("#mdl-feedback").modal('show');
                }
                
                
        });
        
</script>
@endsection