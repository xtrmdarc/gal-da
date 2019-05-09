<!DOCTYPE html>
@php
    setlocale(LC_ALL,"es_ES");
@endphp
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:700,100,200,300,400">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body{
            font-family: 'Open Sans', sans-serif;
            
        }
        .info-factura-vendedor p{
            margin: 0px !important;
            padding: 0px !important;
        }
        .info-factura-vendedor {
            font-size: 1.1em;
        }
        .valor-factura h1{
            font-size: 3em;
        }
        .valor-factura p{
            font-size: 1.2em;
            margin : 0px;
            padding: 0px;
        }

        .tabla-facturacion-detalle thead tr {
            border-top: hidden;
            border-bottom: 1px solid black !important;
        }
        
        .tabla-facturacion-detalle {

            font-size: 1.2em;
        }
        .tabla-facturacion-detalle tbody tr:first-child 
        {
            border-top: 1px solid black !important;
        }

        .tabla-facturacion-detalle tbody tr td
        {
            border-bottom: 1px solid black;
        }

        /* Totales  */
        .totales-montos td {
            border: none !important;
        }
        .totales-montos td:nth-last-child(1){
            border-top: 1px solid black !important;
        }

        .totales-montos td:nth-last-child(2){
            border-top: 1px solid black !important;
        }
        .info-fact-cliente{
            font-size: 1.2em;
        }
        .info-fact-cliente p{
            padding: 0px;
            margin: 0px;
        }
        .info-fact-fecha-pago
        {
            font-size: 1.2em;
        }
        .info-fact-fecha-pago p
        {
            padding: 0px;
            margin: 0px;
        }
    </style>
</head>

<body>
    <div class="container">
        {{-- Header Banner --}}
        <div>

        </div>
        {{-- Header --}}
    
        <div class="row" >
            <div class="col-sm-12" style="display:block">
                <div class="row">
                    <div class="col-sm-6"   style="float:left">
                        <img src="https://gal-da.com/home/images/logo-1.png" alt="logo 1" width="50%">
                        <h1 style="font-size:1.8em;"> <b> Recibo {{$param['nro_pedido']}} </b></h1>
                    </div>
                    <div class="col-sm-6"  style="float:left">
                        <div  class="info-factura-vendedor text-right" >
                            <p>Limaton Corp S.A.C</p>
                            <p>Pro. Paseo La Castellana Nro. 1260. 4to Piso. </p>
                            <p>Lima, Santiago de Surco 15024 </p>
                            <p>Perú</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div  class="row " style="padding-left:10%;padding-top:170px;padding-right:10%;">
            <div class="row justify-content-md-center" style="height:180px">

                <div class="col col-sm-5 valor-factura" style="float:left;">
                    <h1><b> ${{$plan_culqi->precio}}<span style="font-size:0.5em; "> {{$plan_culqi->codigo_moneda}} </span> </b> </h1> 
                    <p class="m-0 p-0"><b>Monto cancelado</b></p>
                    <p class="m-0 p-0">{{ strftime("%c",$param['ahora']->getTimestamp()) }} </p>
                </div>
                
                <div class="col col-sm-5 valor-factura" style="float:left;">
                    <p><b> Método de pago</b></p>
                    {{-- <p>Visa terminada en {{$tarjeta->card_last_four}} </p> --}}
                    <p>Visa terminada en **** </p>
                    <p style="margin-top:11px"><b>Concepto de facturación</b></p>
                    <p>{{ strftime("%b. %d, %G",$param['ahora']->getTimestamp()) }} </p>
                </div>
                
            </div>
            {{-- Content --}}
            <div class="row "  >

                <table class="table tabla-facturacion-detalle">
                    <thead>
                        <tr>
                            <th>Suscripción</th>
                            <th></th>
                            <th></th>
                            <th class="text-right">${{$plan_culqi->precio }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$plan_culqi->nombre_plan }} <br> <span style="color:#666">{{$plan_culqi->id_periodicidad==1?'Cada 30 días':'Cada 365 días' }} </span>  </td>
                            <td></td>
                            <td></td>
                            <td class="text-right">${{$plan_culqi->precio}} </td>
                        </tr>
                        <tr class="totales-montos" style="padding-top:0px;">
                            <td > </td>
                            <td ></td>
                            <td>Subtotal</td>
                            <td class="text-right">${{$plan_culqi->precio}}</td>
                        </tr>
                        <tr  class="totales-montos" >
                            <td> </td>
                            <td></td>
                            <td><b> Total</b></td>
                            <td class="text-right"> <b>${{$plan_culqi->precio}}</b></td>
                        </tr>
                    </tbody>
                </table>

                <div class="info-fact-cliente" style="padding-top:20px;">
                    <p><b>Cuenta facturada:</b></p>
                    <p>{{$billing_info->EsEmpresarial==1?$billing_info->RazonSocial:session('datosempresa')->nombre_empresa}} </p>
                    <p>{{$billing_info->Email}} </p>
                    <p>{{$billing_info->Nombre.' '.$billing_info->Apellido}} </p>
                    <p>{{$billing_info->Direccion}} </p>
                    <p>{{$billing_info->Ciudad}}, <!-- Podria ir el codigo postal !--> </p>
                    <p>{{$billing_info->CodigoPais}}</p>

                </div> 

                <div class="info-fact-fecha-pago" style="padding-top:20px;">
                    <p><b>Cronología de Pagos:</b></p>
                    <p>Recibo creado</p>
                    <p>{{ strftime("%b. %d, %G",$param['ahora']->getTimestamp()) }}</p>  
                    <p style="padding-top:10px">Recibo pagado</p>
                    <p>{{ strftime("%b. %d, %G",$param['ahora']->getTimestamp()) }}</p>
                </div> 

                <p class="text-center" style="font-size:1.2em; padding-top:50px;"> Por favor contacta a  <b>facturacion@gal-da.com</b>  si tienes alguna pregunta referente a
                        este comprobante. </p>
            </div>

        </div>  
    </div>
</body>
</html>