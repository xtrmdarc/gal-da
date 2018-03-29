@extends('Layouts.master')

@section('content')
<div class="wrapper wrapper-content animated fadeIn ng-scope">
    <div class="ibox-content m-b-sm border-bottom">
        <div class="p-xs">
            <div class="pull-left m-r-md">
                <i class="fa fa-cogs mid-icon"></i>
            </div>
            <h2 class="m-t-none">Central de ajustes</h2> <span>Controla todos los ajustes del sistema desde este panel.</span>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="ibox">
                <div class="ibox-title">
                    <h5><i class="fa fa-bitbucket"></i> Restaurante</h5>
                </div>
                <div class="ibox-content no-padding">
                    <div class="list-group">
                        <a class="list-group-item" href="{{ url('/ajustesCaja') }}">
                            <h4 class="list-group-item-heading">Cajas</h4>
                            <p class="list-group-item-text">Creaci&oacute;n, modificaci&oacute;n.</p>
                        </a>
                        <a class="list-group-item" href="{{ url('/ajustesAlmacen') }}">
                            <h4 class="list-group-item-heading">Almacenes y &Aacute;reas de Producci&oacute;n</h4>
                            <p class="list-group-item-text">Creaci&oacute;n, modificaci&oacute;n.</p>
                        </a>
                        <a class="list-group-item" href="{{ url('/ajustesSalonyMesas') }}">
                            <h4 class="list-group-item-heading">Salones y mesas</h4>
                            <p class="list-group-item-text">Creaci&oacute;n, modificaci&oacute;n.</p>
                        </a>
                        <a class="list-group-item" href="{{ url('/ajustesProductos') }}">
                            <h4 class="list-group-item-heading">Productos</h4>
                            <p class="list-group-item-text">Creaci&oacute;n, modificaci&oacute;n.</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="ibox">
                <div class="ibox-title">
                    <h5><i class="fa fa-desktop"></i> Sistema</h5>
                </div>
                <div class="ibox-content no-padding">
                    <div class="list-group">
                        <a class="list-group-item" href="{{ url('/ajustesDatosEmpresa') }}">
                            <h4 class="list-group-item-heading">Datos de la empresa</h4>
                            <p class="list-group-item-text">Informaci&oacute;n de mi negocio.</p>
                        </a>
                        <a class="list-group-item" href="{{ url('/ajustesTipoDocumento') }}">
                            <h4 class="list-group-item-heading">Tipo de Documentos</h4>
                            <p class="list-group-item-text">Modificar los tipos de documentos.</p>
                        </a>
                        <a class="list-group-item" href="{{ url('/ajustesUsuarios') }}">
                            <h4 class="list-group-item-heading">Usuarios</h4>
                            <p class="list-group-item-text">Alta de usuarios.</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!--
        <div class="col-sm-4">
            <div class="ibox">
                <div class="ibox-title">
                    <h5><i class="fa fa-line-chart"></i> Indicadores</h5>
                </div>
                <div class="ibox-content no-padding">
                    <div class="list-group">
                        <a class="list-group-item" href="?c=Config&a=IndexI01">
                            <h4 class="list-group-item-heading">M&aacute;rgen de Ventas (por d&iacute;a)</h4>
                            <p class="list-group-item-text">Indicador para controlar los m&aacute;rgenes de sus ventas.</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        -->
    </div>
</div>

<script type="text/javascript">
    $('#navbar-c').addClass("white-bg");
    $('#config').addClass("active");
</script>

@endsection('content')