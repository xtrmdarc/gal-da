@extends('layouts.application.master')
@section('content')
    <div class="page-wrapper">
        <div class="wrapper wrapper-content animated fadeIn ">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-two">


                            <h3>Allison Walker</h3>
                            <div class="desc">
                                Agrega o Modifica tu perfil, pagos o suscripcion.
                            </div>
                            <div class="card-body p-b-0">
                                <h1 class="card-title"><i class="fa fa-user mid-icon"></i> Administracion de Cuenta</h1>
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs customtab" role="tablist">
                                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#u_perfil" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Perfil</span></a> </li>
                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#u_pago" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Pago</span></a> </li>
                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#u_suscripcion" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Suscripcion</span></a> </li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane active" id="u_perfil" role="tabpanel">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="card-body" style="padding-top: 20px;">
                                                    <form class="form-horizontal form-material" method="post" enctype="multipart/form-data" action="/perfilEditar">
                                                        @csrf
                                                        <h4><i class="fa fa-user mid-icon"></i><b> Informacion Personal</b></h4>
                                                        <span>Administra tu cuenta e informacion personal</span>

                                                        <header style="padding-top: 129px;padding-bottom: 20px;">
                                                            <div class="avatar">
                                                                <img src="{{ $imagen_g }}" />
                                                                <input type="hidden" name="imagen_p" value="{{$imagen_g}}" />
                                                            </div>
                                                            <input type="file" name="imagen_p"/>
                                                        </header>
                                                        <div class="form-group" style="padding-top: 20px;">
                                                            <label class="col-md-12">Nombres</label>
                                                            <div class="col-md-12">
                                                                <input type="text" id="nombres_p" name="nombres_p" placeholder="Ingrese sus Nombres" class="form-control form-control-line" value="{{$nombres}}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-md-6">Apellido Paterno</label>
                                                            <div class="col-md-6">
                                                                <input type="text" id="a_paterno_p" name="a_paterno_p" placeholder="Ingrese su Apellido Paterno" class="form-control form-control-line" value="{{$ape_paterno}}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-6">Apellido Materno</label>
                                                            <div class="col-md-6">
                                                                <input type="text" id="a_materno_p" name="a_materno_p" placeholder="Ingrese su Apellido Materno" class="form-control form-control-line" value="{{$ape_materno}}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="example-email" class="col-md-6">Email</label>
                                                            <div class="col-md-6">
                                                                <input type="email" placeholder="Ingrese su Email" class="form-control form-control-line" name="email_p" id="email_p" value="{{$email}}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-md-6">Telefono/Celular</label>
                                                            <div class="col-md-6">
                                                                <input type="text" id="telefono_p" name="telefono_p" placeholder="Ingrese su Telefono" class="form-control form-control-line" value="{{$phone}}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-md-6">Dni</label>
                                                            <div class="col-md-6">
                                                                <input type="text" id="dni_p" name="dni_p" placeholder="Ingrese su Dni" class="form-control form-control-line" value="{{$dni}}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-6">Select Country</label>
                                                            <div class="col-sm-6">
                                                                <select class="form-control form-control-line">
                                                                    <option>London</option>
                                                                    <option>India</option>
                                                                    <option>Usa</option>
                                                                    <option>Canada</option>
                                                                    <option>Thailand</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-12">
                                                                <button type="submit" class="btn btn-success"> Guardar </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="card-body" style="padding-top: 20px;">
                                                    <form class="form-horizontal form-material">
                                                        <h4><i class="fa fa-list mid-icon"></i><b> Password</b></h4>
                                                        <span>Modifica tus contrasenias.</span>

                                                        <div class="form-group" style="padding-top: 20px;">
                                                            <label class="col-md-12">Password Actual</label>
                                                            <div class="col-md-12">
                                                                <input type="password" value="password" class="form-control form-control-line">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-12">Nuevo Password</label>
                                                            <div class="col-md-12">
                                                                <input type="password" value="password" class="form-control form-control-line">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-12">Confirmar nuevo Password</label>
                                                            <div class="col-md-12">
                                                                <input type="password" value="password" class="form-control form-control-line">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-sm-12">
                                                                <button class="btn btn-success"> Guardar </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane  p-20" id="u_pago" role="tabpanel">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card-body" style="padding-top: 20px;">
                                                    <form class="form-horizontal form-material">
                                                        <h4><i class="fa fa-user mid-icon"></i><b> Tipo de Pago</b></h4>
                                                        <span>Seleccione su metodo de pago preferido</span>

                                                        <div class="form-group" style="padding-top: 20px;">
                                                            <label class="col-md-12">Nombre</label>
                                                            <div class="col-md-12">
                                                                <input type="text" placeholder="John Doe" class="form-control form-control-line">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-md-12">Apellido</label>
                                                            <div class="col-md-12">
                                                                <input type="text" placeholder="John Doe" class="form-control form-control-line">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-md-12">Numero de Tarjeta</label>
                                                            <div class="col-md-12">
                                                                <input type="text" placeholder="John Doe" class="form-control form-control-line">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-4"></label>
                                                            <div class="col-md-4">
                                                                <input type="text" placeholder="MM" class="form-control form-control-line">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="example-email" class="col-md-4"></label>
                                                            <div class="col-md-4">
                                                                <input type="email" placeholder="YY" class="form-control form-control-line" name="example-email" id="example-email">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-md-4"></label>
                                                            <div class="col-md-4">
                                                                <input type="text" placeholder="CVC" class="form-control form-control-line">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-sm-12">
                                                                <button class="btn btn-success"> Guardar </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card-body" style="padding-top: 20px;">
                                                    <form class="form-horizontal form-material">
                                                        <h4><i class="fa fa-list mid-icon"></i><b> Recibos</b></h4>
                                                        <span>Revisa tus recibos mensuales.</span>

                                                        <table class="table table-striped" style="margin-top: 20px;">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Name</th>
                                                                <th>Price</th>
                                                                <th></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <th scope="row">1</th>
                                                                <td>Kolor Tea Shirt For Man, January 22</td>
                                                                <td class="color-primary">$21.56</td>
                                                                <td><a href="">Mirar Recibo</a></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">2</th>
                                                                <td>Kolor Tea Shirt For Women, January 30</td>
                                                                <td class="color-success">$55.32</td>
                                                                <td><a href="">Mirar Recibo</a></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">3</th>
                                                                <td>Blue Backpack For Baby, January 25</td>
                                                                <td class="color-danger">$14.85</td>
                                                                <td><a href="">Mirar Recibo</a></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane p-20" id="u_suscripcion" role="tabpanel">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card-body" style="padding-top: 20px;">
                                                    <form class="form-horizontal form-material">
                                                        <h4><i class="fa fa-list mid-icon"></i><b> Plan Actual</b></h4>
                                                        <span>Administra tu actual suscripcion, actualiza tu plan.</span>

                                                        <h5 class="m-t-30"><b>Plan Free</b> - $0.0 mensual</h5>
                                                        <h5 class="m-t-30">N de Ventas al momento: <span><b>70</b> de 1000</span> <span class="pull-right">70</span></h5>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%; height:6px;"> <span class="sr-only">50% Complete</span> </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <button class="btn btn-success"> Guardar </button>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <button class="btn btn-success"> Cancelar </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{URL::to('rest/scripts/informes/func_inf.js' )}}"></script>

    <script type="text/javascript">
        $('#navbar-c').addClass("white-bg");
        $('#informes').addClass("active");
    </script>
@endsection