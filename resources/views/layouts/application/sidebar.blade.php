 <!-- Left Sidebar  -->
<div class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                @if(Auth::user()->plan_id == '1')
                    {{--/*PLAN FREE*/--}}

                        <li class="nav-devider"></li>
                        <li class="nav-label"> Plan Free </li>
                        @if(Auth::user()->id_rol == '1')
                            <li class="nav-label"> Rol : ADMINISTRADOR </li>
                        @endif
                        @if(Auth::user()->id_rol == '2')
                            <li class="nav-label"> Rol : CAJERO </li>
                        @endif
                        @if(Auth::user()->id_rol == '3')
                            <li class="nav-label"> Rol : PRODUCCIÓN </li>
                        @endif
                        @if(Auth::user()->id_rol == '4')
                            <li class="nav-label"> Rol : MOZO </li>
                        @endif
                        @if(Auth::user()->id_rol == '5')
                            <li class="nav-label"> Rol : MULTIMOZO </li>
                        @endif
                        <li class="nav-devider"></li>
                        <li class="nav-label"> Produccion</li>
                        @if(Auth::user()->id_rol == '1' || Auth::user()->id_rol == '2' || Auth::user()->id_rol == '4')
                            <li><a href="/inicio"> <i class="fa fa-dashboard"></i><span class="hide-menu">Pedidos</span></a></li>
                        @endif
                        @if(Auth::user()->id_rol == '1' || Auth::user()->id_rol == '3')
                            <li><a href="/cocina"> <i class="fa fa-dashboard"></i><span class="hide-menu">Cocina</span></a></li>
                        @endif
                        <li class="nav-devider"></li>
                        <li class="nav-label"> Administracion</li>
                        <li><a href="/tableroF"> <i class="fa fa-bar-chart"></i><span class="hide-menu">Tablero de Control </span></a></li>
                        @if(Auth::user()->id_rol == '1' || Auth::user()->id_rol == '2')
                            <li><a href="/cliente"> <i class="fa fa-suitcase"></i><span class="hide-menu">Clientes</span></a></li>
                        @endif
                        @if(Auth::user()->id_rol == '1' || Auth::user()->id_rol == '2')
                            <li> <a class="has-arrow " href="#" aria-expanded="false"><i class="fa fa-envelope"></i><span class="hide-menu">Caja</span></a>
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
                        @if(Auth::user()->id_rol == '1' || Auth::user()->id_rol == '2')
                            <li ><a class="has-arrow " href="#" aria-expanded="false"><i class="fa fa-wpforms"></i><span class="hide-menu"> Configuración</span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="{{route('ajustes')}}">Todos los Ajustes</a></li>
                                    <li><i class="fa fa-bitbucket"></i><span class="hide-menu"> <b>Restaurante</b></span></li>
                                    <li><a href="{{route('config.Cajas')}}">Cajas </a></li>
                                    <li><a href="{{route('config.Almacen')}}">Almacen</a></li>
                                    <li><a href="{{route('config.Almacen')}}">Areas de Produccion</a></li>
                                    <li><a href="{{route('config.SalonesMesas')}}">Salon y Mesas </a></li>
                                    <li><a href="{{route('config.Productos')}}">Productos </a></li>
                                    <li><i class="fa fa-desktop"></i><span class="hide-menu"> <b>Sistema</b></span></li>
                                    <li><a href="{{route('config.DatosEmpresa')}}">Datos de Empresa </a></li>
                                    <li><a href="{{route('config.TiposdeDocumentos')}}">Tipos de Documentos </a></li>
                                    <li><a href="{{route('config.Usuarios')}}">Usuarios </a></li>
                                    <li><a href="{{route('config.Turnos')}}">Turnos </a></li>
                                </ul>
                            </li>
                        @endif
                        <li class=""></li>

                    {{--/*
                    <li class="text-center " style="20px"><a class="btn  upgrade-btn" href="/upgrade"> <span class="hide-menu">Crecer</span></a></li>
                    */--}}

                    @else
                    {{--/*PLAN LITE*/--}}
                        <li class="nav-devider"></li>
                        <li class="nav-label"> Plan Lite </li>
                        <li class="nav-devider"></li>
                        <li class="nav-label"> Produccion </li>
                        @if(Auth::user()->id_rol == '1' || Auth::user()->id_rol == '2' || Auth::user()->id_rol == '4')
                            <li><a href="/inicio"> <i class="fa fa-dashboard"></i><span class="hide-menu">Pedidos</span></a></li>
                        @endif
                        @if(Auth::user()->id_rol == '1' || Auth::user()->id_rol == '3')
                            <li><a href="/cocina"> <i class="fa fa-dashboard"></i><span class="hide-menu">Cocina</span></a></li>
                        @endif
                        <li class="nav-label"> Administración</li>
                        <li><a href="/tablero"> <i class="fa fa-bar-chart"></i><span class="hide-menu">Tablero de Control</span></a></li>
                        @if(Auth::user()->id_rol == '1' || Auth::user()->id_rol == '2')
                            <li> <a class="has-arrow " href="#" aria-expanded="false"><i class="fa fa-envelope"></i><span class="hide-menu">Caja</span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="{{route('apercaja')}}">Apertura de caja</a></li>
                                    <li><a href="{{route('ingcaja')}}">Ingresos </a></li>
                                    <li><a href="{{route('egrcaja')}}">Egresos</a></li>
                                </ul>
                            </li>
                        @endif
                        <li><a href="/cliente"> <i class="fa fa-suitcase"></i><span class="hide-menu">Clientes</span></a></li>
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-bar-chart"></i><span class="hide-menu">Compras</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="/compras"> Compras</a></li>
                                <li><a href="/proveedores"> Proveedores </a></li>
                            </ul>
                        </li>
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-bar-chart"></i><span class="hide-menu">Créditos</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="/creditos"> Compras</a></li>
                            </ul>
                        </li>
                        @if(Auth::user()->id_rol == '1')
                        <li><a href="/informes"> <i class="fa fa-table"></i><span class="hide-menu"> Informes </span></a></li>
                           {{--/*
                            <li><a class="has-arrow " href="#" aria-expanded="false"> <i class="fa fa-table"></i><span class="hide-menu"> Informes </span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="{{route('config.Informes')}}">Todos los Informes</a></li>
                                    <li><i class="fa fa-bitbucket"></i><span class="hide-menu"> <b>Ventas</b></span></li>
                                    <li><a href="{{route('config.Cajas')}}">Todas las Ventas </a></li>
                                    <li><a href="{{route('config.Almacen')}}">Ventas por Producto</a></li>
                                    <li><a href="{{route('config.Almacen')}}">Ventas por mesero</a></li>
                                    <li><a href="{{route('config.SalonesMesas')}}">Ventas por forma de pago </a></li>
                                    <li><i class="fa fa-desktop"></i><span class="hide-menu"> <b>Compras</b></span></li>
                                    <li><a href="{{route('config.SalonesMesas')}}">Todos las Comprass </a></li>
                                    <li><a href="{{route('config.SalonesMesas')}}">Comopras por proveedor </a></li>
                                    <li><i class="fa fa-desktop"></i><span class="hide-menu"> <b>Finanzas</b></span></li>
                                    <li><a href="{{route('config.SalonesMesas')}}">Aper y Cierre de Caja </a></li>
                                    <li><a href="{{route('config.SalonesMesas')}}">Todos los Ingresos </a></li>
                                    <li><a href="{{route('config.SalonesMesas')}}">Todos los Egresos </a></li>
                                    <li><a href="{{route('config.SalonesMesas')}}">Egresos por Remuneracion </a></li>
                                    <li><i class="fa fa-desktop"></i><span class="hide-menu"> <b>Inventario</b></span></li>
                                    <li><a href="{{route('config.SalonesMesas')}}">Kardex </a></li>
                                </ul>
                            </li>
                           */--}}
                        @endif
                        @if(Auth::user()->id_rol == '1' || Auth::user()->id_rol == '2')
                        <li ><a class="has-arrow " href="#" aria-expanded="false"><i class="fa fa-wpforms"></i><span class="hide-menu"> Configuración</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{route('ajustes')}}">Todos los Ajustes</a></li>
                                <li><i class="fa fa-bitbucket"></i><span class="hide-menu"> <b>Restaurante</b></span></li>
                                <li><a href="{{route('config.Cajas')}}">Cajas </a></li>
                                <li><a href="{{route('config.Almacen')}}">Almacen</a></li>
                                <li><a href="{{route('config.Almacen')}}">Areas de Produccion</a></li>
                                <li><a href="{{route('config.SalonesMesas')}}">Salon y Mesas </a></li>
                                <li><a href="{{route('config.Productos')}}">Productos </a></li>
                                <li><i class="fa fa-desktop"></i><span class="hide-menu"> <b>Sistema</b></span></li>
                                <li><a href="{{route('config.DatosEmpresa')}}">Datos de Empresa </a></li>
                                <li><a href="{{route('config.TiposdeDocumentos')}}">Tipos de Documentos </a></li>
                                <li><a href="{{route('config.Usuarios')}}">Usuarios </a></li>
                                <li><a href="{{route('config.Sucursal')}}">Sucursales </a></li>
                                <li><a href="{{route('config.Turnos')}}">Turnos </a></li>
                            </ul>
                        </li>
                        @endif
                        <li class="nav-devider"></li>
                @endif

                {{--/*
                <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-suitcase"></i><span class="hide-menu">Bootstrap UI <span class="label label-rouded label-warning pull-right">6</span></span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="ui-alert.html">Alert</a></li>
                        <li><a href="ui-button.html">Button</a></li>
                        <li><a href="ui-dropdown.html">Dropdown</a></li>
                        <li><a href="ui-progressbar.html">Progressbar</a></li>
                        <li><a href="ui-tab.html">Tab</a></li>
                        <li><a href="ui-typography.html">Typography</a></li>
                    </ul>
                </li>
                <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-suitcase"></i><span class="hide-menu">Components <span class="label label-rouded label-danger pull-right">6</span></span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="uc-calender.html">Calender</a></li>
                        <li><a href="uc-datamap.html">Datamap</a></li>
                        <li><a href="uc-nestedable.html">Nestedable</a></li>
                        <li><a href="uc-sweetalert.html">Sweetalert</a></li>
                        <li><a href="uc-toastr.html">Toastr</a></li>
                        <li><a href="uc-weather.html">Weather</a></li>
                    </ul>
                </li>
                <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-wpforms"></i><span class="hide-menu">Forms</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="form-basic.html">Basic Forms</a></li>
                        <li><a href="form-layout.html">Form Layout</a></li>
                        <li><a href="form-validation.html">Form Validation</a></li>
                        <li><a href="form-editor.html">Editor</a></li>
                        <li><a href="form-dropzone.html">Dropzone</a></li>
                    </ul>
                </li>
                <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-table"></i><span class="hide-menu">Tables</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="table-bootstrap.html">Basic Tables</a></li>
                        <li><a href="table-datatable.html">Data Tables</a></li>
                    </ul>
                </li>
                <li class="nav-label">Layout</li>
                <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-columns"></i><span class="hide-menu">Layout</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="layout-blank.html">Blank</a></li>
                        <li><a href="layout-boxed.html">Boxed</a></li>
                        <li><a href="layout-fix-header.html">Fix Header</a></li>
                        <li><a href="layout-fix-sidebar.html">Fix Sidebar</a></li>
                    </ul>
                </li>
                <li class="nav-label">EXTRA</li>
                <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-book"></i><span class="hide-menu">Pages <span class="label label-rouded label-success pull-right">8</span></span></a>
                    <ul aria-expanded="false" class="collapse">

                        <li><a href="#" class="has-arrow">Authentication <span class="label label-rounded label-success">6</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="page-login.html">Login</a></li>
                                <li><a href="page-register.html">Register</a></li>
                                <li><a href="page-invoice.html">Invoice</a></li>
                            </ul>
                        </li>
                        <li><a href="#" class="has-arrow">Error Pages</a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="page-error-400.html">400</a></li>
                                <li><a href="page-error-403.html">403</a></li>
                                <li><a href="page-error-404.html">404</a></li>
                                <li><a href="page-error-500.html">500</a></li>
                                <li><a href="page-error-503.html">503</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-map-marker"></i><span class="hide-menu">Maps</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="map-google.html">Google</a></li>
                        <li><a href="map-vector.html">Vector</a></li>
                    </ul>
                </li>
                <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-level-down"></i><span class="hide-menu">Multi level dd</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="#">item 1.1</a></li>
                        <li><a href="#">item 1.2</a></li>
                        <li> <a class="has-arrow" href="#" aria-expanded="false">Menu 1.3</a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="#">item 1.3.1</a></li>
                                <li><a href="#">item 1.3.2</a></li>
                                <li><a href="#">item 1.3.3</a></li>
                                <li><a href="#">item 1.3.4</a></li>
                            </ul>
                        </li>
                        <li><a href="#">item 1.4</a></li>
                    </ul>
                </li>
                */--}}
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</div>
        <!-- End Left Sidebar  -->