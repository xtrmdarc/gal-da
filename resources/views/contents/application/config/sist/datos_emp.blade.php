@extends('layouts.application.master')

@section('content')

<input type="hidden" id="m" value=""/>
<div class="page-wrapper">

<form id="frm-datos-empresa" action="/ajustesDatosEmpresa" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{$id}}" />
    <div class="col-lg-8">
        <div class="wrapper wrapper-content animated bounce">
            <div class="row">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><i class="fa fa-building"></i> Datos de la empresa</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="ct-wizard-blue" id="wizardProfile">
                                    <div class="picture-container">
                                        <div class="picture">
                                            <img src="{{$logo_g}}" class="picture-src" id="wizardPicturePreview" title="" style="width: 303px;"/>
                                            <input type="hidden" name="logo" value="{{$logo_g}}" />
                                            <input type="file" name="logo" id="wizard-picture">
                                        </div>
                                        <h6>Cambiar Imagen</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label">RAZ�N SOCIAL</label>
                                            <input type="text" name="razon_social" value="{{$razon_social}}" class="form-control" placeholder="Raz�n Social" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">ABREVIATURA</label>
                                            <input type="text" name="abrev_rs" value="{{$abrev_rs}}" class="form-control" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">IMPUESTO A LA VENTA</label>
                                            <div class="input-group">
                                                <input type="text" name="igv" value="{{$igv}}" class="form-control" placeholder="Impuesto" autocomplete="off" required/>
                                                <span class="input-group-addon">%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">{{$identificacionTributaria}}:</label>
                                            <input type="text" name="ruc" value="{{$ruc}}" class="form-control" placeholder="Ingrese RUC" maxlength="11" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">MONEDA:</label>
                                            <input type="text" name="moneda" value="{{$moneda}}" class="form-control" placeholder="Ingrese Moneda" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label">TEL�FONO:</label>
                                            <input type="text" name="telefono" value="{{$telefono}}" class="form-control" placeholder="Ingrese Tel�fono" autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">DIRECCI�N:</label>
                                    <input type="text" name="direccion" value="{{$direccion}}" class="form-control" placeholder="Ingrese direcci�n" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Pais</label>
                                    <div class="input-group">
                                        {{--<span class="input-group-addon"><i class="fa fa-renren"></i></span>--}}
                                        <select name="country" id="country" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off" required="required" >
                                            <optgroup label="Seleccionar">
                                                @foreach($paises as $r)
                                                    @if($r->codigo == $userPais)
                                                        <option selected="selected" value="{{$r->codigo}}">{{$r->nombre}}</option>
                                                    @else
                                                        <option value="{{$r->codigo}}">{{$r->nombre}}</option>
                                                    @endif
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>

                                    @if ($errors->has('country'))
                                        <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('country') }}</strong>
                                                </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-footer">
                        <div class="text-right">
                            <button class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="col-lg-4">
    <div class="wrapper wrapper-content">
        <div class="panel panel-transparent panel-dashed tip-sales text-center">
            <div class="row">
                <div class="col-sm-8 col-sm-push-2">
                    <h2 class="ich m-t-none">Realize cambios</h2>
                    <i class="fa fa-long-arrow-left fa-3x"></i>
                    <p class="ng-binding">Modifique los datos de su empresa.</p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="{{URL::to('rest/scripts/config/func_de.js' )}}"></script>
<script type="text/javascript">
    $('#config').addClass("active");
</script>
<script>
    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#wizardPicturePreview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#wizard-picture").change(function() {
        readURL(this);
    });
</script>
@endsection('content')