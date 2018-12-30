@extends('layouts.application.master')

@section('content')

<input type="hidden" id="m" value=""/>
<div class="wrapper wrapper-content">

    <div class="row">
        <div class="col-lg-8">
            <div class="ibox animated bounce">
                <form id="frm-datos-empresa" action="/ajustesDatosEmpresa" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$id}}" />
                    <div class="ibox-title">
                        <h5><i class="fa fa-building"></i> Datos de la empresa</h5>
                    </div>
                    <div class="ibox-content my-scroll">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="ct-wizard-blue" id="wizardProfile">
                                    <div class="picture-container">
                                        <div class="picture">
                                            <img src="{{$logo_g}}" class="picture-src" id="wizardPicturePreview" title="" style="width: 265px;"/>
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
                                            <label class="control-label">RAZÓN SOCIAL</label>
                                            <input type="text" name="razon_social" value="{{$razon_social}}" class="form-control" placeholder="Razón Social" autocomplete="off" required>
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
                                                <input type="text" name="igv" value="{{$igv*100}}" class="form-control" placeholder="Impuesto" maxlength="2" autocomplete="off" required/>
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
                                            <input type="text" name="moneda" value="{{$moneda}}" class="form-control" placeholder="$ ó S/." autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label">TELÉFONO:</label>
                                            <input type="text" name="telefono" value="{{$telefono}}" class="form-control" placeholder="Ingrese Teléfono" maxlength="13" autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">DIRECCIÓN:</label>
                                    <input type="text" name="direccion" value="{{$direccion}}" class="form-control" placeholder="Ingrese dirección" autocomplete="off" required>
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
                                                    @if($r->codigo == $paisEmpresa)
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
                </form>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="wrapper wrapper-content">
                <div class="text-center">
                    <div class="row">
                        <div class="col-sm-10 block-center">
                            <br>
                            <h1 class="ich m-t-none brand-color">Módulo de Empresa</h1>
                            <br>
                            <p class="ng-binding ">Aquí puedes editar los datos generales de tu negocio. Personalizar la información de tu empresa<strong class="brand-color"> potenciará los beneficios que obtienes de <brand style="white-space:nowrap">Gal-Da.</brand> </strong></p>
                        </div>
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