<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <a class="close-canvas-menu"><i class="fa fa-times"></i></a>
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>

                             </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">

                                    </strong>
                             </span> <span class="text-muted text-xs block">

                                    <b class="caret"></b></span> </span> </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="close_session.php">Salir</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">
                        IN+
                    </div>
                </li>


                <li id="restau">
                    <a href="inicio.php"><i class="fa fa-cutlery"></i> <span class="nav-label">RESTAURANTE</span></a>
                </li>

                <li id="caja">
                    <a href="#"><i class="fa fa-desktop"></i> <span class="nav-label">CAJA</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">

                        <li id="c-apc"><a href="lista_caja_aper.php"> Apertura - Cierre</a></li>

                        <li id="c-ing"><a href="lista_caja_ing.php"> Ingresos</a></li>
                        <li id="c-egr"><a href="lista_caja_egr.php"> Egresos</a></li>
                    </ul>
                </li>
                <li id="clientes">
                    <a href="lista_tm_clientes.php"><i class="fa fa-group"></i> <span class="nav-label">CLIENTES</span></a>
                </li>
                <li id="compras">
                    <a href="#"><i class="fa fa-shopping-cart"></i> <span class="nav-label">COMPRAS</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li id="c-compras"><a href="lista_comp.php"> Todas las compras</a></li>
                        <li id="c-proveedores"><a href="lista_comp_prov.php"> Proveedores</a></li>
                    </ul>
                </li>
                <li id="creditos">
                    <a href="#"><i class="fa fa-credit-card"></i> <span class="nav-label">CREDITOS</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li id="cr-compras"><a href="lista_creditos_comp.php"> Compras</a></li>
                    </ul>
                </li>


                <li id="informes">
                    <a href="lista_tm_informes.php"><i class="fa fa-list"></i> <span class="nav-label">INFORMES</span></a>
                </li>


                <li id="area-p">
                    <a href="lista_area_prod.php"><i class="fa fa-bitbucket"></i> <span class="nav-label"></span></a>
                </li>


                <li id="config">
                    <a href="lista_tm_otros.php"><i class="fa fa-cogs"></i> <span class="nav-label">AJUSTES</span></a>
                </li>


                <li id="tablero">
                    <a href="lista_tm_tablero.php"><i class="fa fa-dashboard"></i> <span class="nav-label">TABLERO</span></a>
                </li>

            </ul>
        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg" style="min-height: 307px;">
        <div class="row border-bottom">
            <nav id="navbar-c" class="navbar navbar-fixed-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-warning-2 " href="#"><i class="fa fa-bars"></i> </a>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <span class="dateday" id="dateday"></span>
                        <span class="dateday" id="datedays"></span>
                    </li>
                    <li>
                        <span class="datetime" id="datetime"></span>
                    </li>
                    <li>
                        <a href="close_session.php">
                            <i class="fa fa-sign-out"></i> Salir
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
