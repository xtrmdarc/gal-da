@extends('layouts.application.master')

@section('content')


    <input type="hidden" id="m" value=""/>
    
    <div class="wrapper wrapper-content animated bounce">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        @if(Auth::user()->plan_id == '1')
                            <h5><i class="fa fa-newspaper-o"></i> Usuarios - <span id="usuarios_count">{{ $usuarios_cant }}</span>/{{session('plan_actual')->usuario_max}}
                                {{-- <div class="tooltip-g"><i class="mdi mdi-alert-octagon font-18 vertical-middle"></i>
                                    <span class="tooltiptext-g">El usuario propietario también es considerado como usuario del sistema</span>
                                </div> --}}
                            </h5>
                        @else
                            <h5><i class="fa fa-newspaper-o"></i> Usuarios 
                                {{-- <div class="tooltip-g"><i class="mdi mdi-alert-octagon font-18 vertical-middle"></i>
                                    <span class="tooltiptext-g">El usuario propietario también es considerado como usuario del sistema</span>
                                </div> --}}
                            </h5>
                        @endif
                        
                        <div class="pull-right">
                            {{-- {{dd($usuarios_cant<session('plan_actual')->usuario_max?true:false)}} --}}
                            @if(  $usuarios_cant < session('plan_actual')->usuario_max  || session('plan_actual')->usuario_max == -1)
                                <a href="/ajustesRegistrarUsuario" id="btn-usuario-nuevo"><button type="button"  class="btn btn-primary"><i class="fa fa-plus-circle"></i> Nuevo Usuario</button></a>
                                {{-- <h5 id="text-limite-usuario" style="display:none" >Limite alcanzado. </h5> --}}
                            @else
                                <h5>
                                    Limite alcanzado - <a class="btn btn-success btn-xs upgrade-btn-2" href="/upgrade">Crecer</a>
                                </h5>
                            @endif  
                        </div>
                    </div>
                    
                    
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-hover table-condensed table-striped" id="table" width="100%">
                                <thead>
                                <tr>
                                    <th>Sucursal</th>
                                    <th>Nombres</th>
                                    <th>Ape.Paterno</th>
                                    <th>Ape.Materno</th>
                                    <th style="text-align: center">Usuario</th>
                                    <th style="text-align: center">Cargo</th>
                                    <th>Pin</th>
                                    {{-- <th style="text-align: center">Estado</th> --}}
                                    <th style="text-align: center;display:none;">Verificado</th>
                                    <th style="text-align: center">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{$user->nombre_sucursal}}</td>
                                    <td>{{$user->nombres}}</td>
                                    <td>{{$user->ape_paterno}}</td>
                                    <td>{{$user->ape_materno}}</td>
                                    <td>{{$user->usuario}}</td>
                                    <td style="text-align: center">
                                        @if($user->id_rol == 1)
                                            <span class="label label-danger">{{$user->desc_r}}</span>
                                        @elseif($user->id_rol == 2)
                                            <span class="label label-primary">{{$user->desc_r}}</span>
                                        @elseif($user->id_rol == 3)
                                            <span class="label label-warning">{{$user->desc_r}}</span>
                                        @elseif($user->id_rol == 4)
                                            <span class="label label-default">{{$user->desc_r}}</span>
                                        @else
                                            <span class="label label-success">{{$user->desc_r}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->pin == '0' || $user->pin == ' ' || $user->pin == '')
                                            No tiene
                                        @else
                                            {{$user->pin}}
                                        @endif

                                    </td>
                                    @php
                                    /*
                                    <td style="text-align: center">
                                        @if($user->estado == 'a')
                                            <a onclick="{{'estadoUsuario('.$user->id_usu.',\'a\');' }}"> <span class="label label-primary">ACTIVO</span></a>
                                        @elseif($user->estado == 'i')
                                            <a onclick="{{'estadoUsuario('.$user->id_usu.',\'i\');'}} "> <span class="label label-danger">INACTIVO</span></a>
                                        @endif
                                    </td>
                                    */
                                    @endphp
                                    <td style="text-align: center;display:none;">
                                        <a><span  @if($user->status == 1) class="label label-primary">Verificado @else class="label label-danger">Pendiente @endif</span></a>
                                    </td>
                                    <td style="text-align: right">
                                        @if($plan_id == 1 && $user->plan_estado == '2')
                                        @else
                                            <a href="/ajustesRUsuario/{{isset($user->index_por_cuenta)?$user->index_por_cuenta:0}}">
                                                <button type="button" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> Editar</button></a>
                                            <button type="button" class="btn btn-danger btn-xs" onclick="eliminarUsuario(<?php echo $user->id_usu.',\''. $user->nombres.' '.$user->ape_paterno.' '.$user->ape_materno.'\''; ?>);"><i class="fa fa-trash-o"></i></button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div id="lizq-s" style="display: block;" class="wrapper wrapper-content">
                    <div class="text-center">
                        <div class="row">
                            <div class="col-sm-10 block-center">
                                <br>
                                    <h1 class="ich m-t-none brand-color">M&oacute;dulo de Usuarios</h1>
                                <br>
                                <p class="ng-binding ">Aqu&iacute; puedes crear, modificar y eliminar usuarios. Los usuarios son importantes para poder <strong class="brand-color"> administrar, organizar y operar los procesos </strong> de tu negocio. Te ayudaran en difrentes puntos de acuerdo a sus roles de <strong class="brand-color"> Mozo, Cajero, Administrador, MultiMozo y Cocinero </strong> para tener una venta exitosa.<strong class="accent-color"> Selecciona un usuario para administrarlo</strong> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal inmodal fade" id="mdl-estado-usu" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content animated bounceInRight">
                <form id="frm-estado-usu" class="unif_modal" method="post" enctype="multipart/form-data" action="/ajustesUsuarioEstado">
                    @csrf
                    <input type="hidden" name="cod_usu" id="cod_usu">
                    <div class="modal-header mh-e">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                        <i class="fa fa-stack-exchange modal-icon"></i>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">Estado</label>
                                    <select name="estado" id="estado_usu" class="selectpicker show-tick form-control" data-live-search-style="begins" data-live-search="true" title="Seleccionar" autocomplete="off" required="required">
                                        <option value="a">ACTIVO</option>
                                        <option value="i">INACTIVO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Aceptar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal inmodal fade" id="mdl-eliminar-usu" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content animated bounceInRight">
                <form id="frm-eliminar-usu" class="unif_modal" method="post" enctype="multipart/form-data" action="/ajustesEliminar">
                    @csrf
                    <input type="hidden" name="cod_usu_e" id="cod_usu_e">
                    <div class="modal-header mh-p">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                        <i class="fa fa-trash-o modal-icon"></i>
                    </div>
                    <div class="modal-body">
                        <div id="mensaje-u"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Aceptar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script src="{{URL::to('rest/scripts/config/func_usuario.js' )}}"></script>
<script>

    $(function(){
        usuario_max = {!! session('plan_actual')->usuario_max !!};
    });

</script>
@endsection('content')