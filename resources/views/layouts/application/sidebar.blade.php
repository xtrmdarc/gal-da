@php
$fecha_anio = date("Y");
$fecha_mes = date("m");
$monthName = '';

switch ($fecha_mes) {
    case "01":
        $monthName = 'ENERO';
    break;
    case "02":
        $monthName = 'FEBRERO';
    break;
    case "03":
        $monthName = 'MARZO';
    break;
    case "04":
        $monthName = 'ABRIL';
    break;
    case "05":
        $monthName = 'MAYO';
    break;
    case "06":
        $monthName = 'JUNIO';
    break;
    case "07":
        $monthName = 'JULIO';
    break;
    case "08":
        $monthName = 'AGOSTO';
    break;
    case "09":
        $monthName = 'SEPTIEMBRE';
    break;
    case "10":
        $monthName = 'OCTUBRE';
    break;
    case "11":
        $monthName = 'NOVIEMBRE';
    break;
    case "12":
        $monthName = 'DICIEMBRE';
    break;
}

$nventas_mensual =  DB::select('SELECT count(*) as nventas_mensual FROM tm_venta v LEFT JOIN tm_usuario u ON u.id_usu = v.id_usu WHERE u.id_empresa = ?
and MONTH(fecha_venta) = ? and YEAR(fecha_venta) = ?',[\Auth::user()->id_empresa,$fecha_mes,$fecha_anio])[0]->nventas_mensual;

$id_empresa = \Auth::user()->id_empresa;
$empresa = DB::table('empresa')->where('id', $id_empresa)->first();
$version_empresa = $empresa->id_version_app;
$certificado_digital = $empresa->certificado_digital;

$facturacion_e = $empresa->factura_e;

if($version_empresa == 0) {
    $mi_version = "1.0.0.8419";
} else {
    $version_app = DB::table('app_version')->where('id_app_version', $version_empresa)->first();
    $mi_version = $version_app->version_number;
}

$rolUser = DB::select('SELECT r.descripcion as rolUser FROM db_rest.tm_rol as r left join tm_usuario as u on u.id_rol = r.id_rol where u.id_usu = ?',[\Auth::user()->id_usu])[0]->rolUser;

$planes = DB::table('planes')->where('id', \Auth::user()->plan_id)->first();

@endphp
 <!-- Left Sidebar  -->
<div class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li id="sidebar_header_mobile" class="nav-label text-center" >  <b><img  src="{{ !empty($logo_g) ? $logo_g : '/application/images/tu_logo.png' }}" style="width: 80px;max-height:64px;" alt="homepage" class="dark-logo" /></b></li>
                    <li class="nav-devider"></li>
                        <li class="nav-label"> <b>Plan {{$planes->nombre}} - </b>{{ $monthName }}<span style="float: right;"><b>{{ $nventas_mensual  }} </b>/ {{($planes->venta_max == '-1' ? '∞' : $planes->venta_max)}}</span></li>
                        <li class="nav-label"> Rol : {{ $rolUser }} </li>
                        <li class="nav-devider"></li>
                        <li class="nav-label"> Produccion</li>
                        @if(Auth::user()->id_rol == '1' || Auth::user()->id_rol == '2' || Auth::user()->id_rol == '4')
                            <li id="sb_pedidos"><a href="/inicio"> <i class="fa fa-book"></i><span class="hide-menu">Pedidos</span></a></li>
                        @endif
                        @if(Auth::user()->id_rol == '1' || Auth::user()->id_rol == '3')
                            <li id="sb_cocina"><a href="/cocina"> <i class="fa fa-home"></i><span class="hide-menu">Cocina</span></a></li>
                        @endif
                        <li class="nav-devider"></li>
                        <li class="nav-label"> Administracion</li>
                        @if(Auth::user()->plan_id == '1')
                            @if(Auth::user()->id_rol == '1')
                            <li id="sb_tablero_f"><a href="/tableroF"> <i class="fa fa-bar-chart"></i><span class="hide-menu">Tablero de Control </span></a></li>
                            @endif
                        @endif
                        @if(Auth::user()->plan_id == '2')
                            @if(Auth::user()->id_rol == '1')
                                <li id="sb_tablero_f"><a href="/tablero"> <i class="fa fa-bar-chart"></i><span class="hide-menu">Tablero de Control </span></a></li>
                            @endif
                        @endif
                        @if(Auth::user()->id_rol == '1' || Auth::user()->id_rol == '2')
                            <li id="sb_clientes_li"><a href="/cliente"> <i class="fa fa-users"></i><span class="hide-menu">Clientes</span></a></li>
                        @endif
                        @if(Auth::user()->plan_id == '3')
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-bar-chart"></i><span class="hide-menu">Inventario</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="/compras"> Compras</a></li>
                                <li><a href="/proveedores"> Proveedores </a></li>
                                <li><a href="/stock"> Stock </a></li>
                            </ul>
                        </li>
                        {{-- <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-bar-chart"></i><span class="hide-menu">Créditos</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="/creditos"> Créditos</a></li>
                            </ul>
                        </li> --}}
                        @endif
                        @if(Auth::user()->id_rol == '1' || Auth::user()->id_rol == '2')
                            <li id="sb_caja_li"> <a class="has-arrow " href="#" aria-expanded="false"><i class="fa fa-wpforms"></i><span class="hide-menu">Caja</span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="{{route('apercaja')}}">Apertura de caja</a></li>
                                    <li><a href="{{route('ingcaja')}}">Ingresos </a></li>
                                    <li><a href="{{route('egrcaja')}}">Egresos</a></li>
                                </ul>
                            </li>
                        @endif
                        @if(Auth::user()->id_rol == '1')
                            <li><a href="/informes"> <i class="fa fa-table"></i><span class="hide-menu"> Informes </span></a></li>
                        @endif
                        @if(Auth::user()->plan_id != '1' && $facturacion_e == 1)
                            @if(Auth::user()->id_rol == '1')
                                <li id="sb_comprobantes_li"> <a class="has-arrow " href="#" aria-expanded="false"><i class="fa fa-wpforms"></i><span class="hide-menu">Comprobantes</span></a>
                                    <ul aria-expanded="false" class="collapse">
                                        <li><a href="/comprobantes/factura">Facturas</a></li>
                                        <li><a href="/comprobantes/boleta">Boletas </a></li>
                                        <li><a href="/comprobantes/nota/credito">Notas crédito</a></li>
                                        <li><a href="/comprobantes/nota/debito">Notas débito</a></li>
                                        <li><a href="/comprobantes/resumen">Resumen diario</a></li>
                                    </ul>
                                </li>
                            @endif
                        @endif
                        @if(Auth::user()->id_rol == '1' )
                            <li ><a id="sb_configuracion" class="has-arrow " href="#" aria-expanded="false"><i class="fa fa-gear"></i><span class="hide-menu"> Configuración</span></a>
                                <ul id="sb_collapse_configuracion" aria-expanded="false" class="collapse">
                                    <li><a href="{{route('ajustes')}}">Todos los Ajustes</a></li>
                                    <li><i class="fa fa-bitbucket"> <b style="font-family: 'open sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;">Restaurante</b></i><span class="hide-menu"></span></li>
                                    <li><a href="{{route('config.Cajas')}}">Cajas </a></li>
                                    <li><a href="{{route('config.Almacen')}}">Almacen</a></li>
                                    <li><a href="{{route('config.Almacen')}}">Áreas de Producción</a></li>
                                    <li><a href="{{route('config.SalonesMesas')}}">Salon y Mesas </a></li>
                                    <li><a href="{{route('config.Productos')}}">Productos </a></li>
                                    <li><i class="fa fa-desktop"> <b style="font-family: 'open sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;">Sistema</b></i><span class="hide-menu"></span></li>
                                    <li id="sb_datos_empresa_cf" ><a href="{{route('config.DatosEmpresa')}}">Datos de Empresa </a></li>
                                    @if(Auth::user()->plan_id != '1' && $facturacion_e == 1)
                                        @if(Auth::user()->id_rol == '1' && session('datosempresa')->factura_e == 1)
                                            <li><a href="{{route('config.Facturacion')}}">E - Facturación
                                                    <b>
                                                        @if(empty($certificado_digital))
                                                            <i class="fa fa-close" style="color: #ef5350!important;"></i>
                                                        @else
                                                            <i class="fa fa-check" style="color: #1fbdb7!important;"></i>
                                                        @endif
                                                    </b></a>
                                            </li>
                                        @endif
                                    @endif
                                    <li><a href="{{route('config.TiposdeDocumentos')}}">Tipos de Documentos </a></li>
                                    <li><a href="{{route('config.Usuarios')}}">Usuarios </a></li>
                                    <li><a href="{{route('config.Sucursal')}}">Sucursales </a></li>
                                    <li><a href="{{route('config.Turnos')}}">Turnos </a></li>
                                </ul>
                            </li>
                        @endif
                        <li class=""></li>
                    <li class="text-center ">
                        <li id="sb_centroayuda" class="text-center"><a class="btn btn-primary" style="margin:8px;" href="{{route('primerosPasos')}}"> <span class="hide-menu"><b>Centro de Ayuda</b></span></a></li>
                    </li>
                    <li class="text-center v-sw" style="position: absolute; bottom: 0; text-align: center; width: 100%;">
                        <p style="">v {{ $mi_version }}</p>
                 </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</div>
        <!-- End Left Sidebar  -->