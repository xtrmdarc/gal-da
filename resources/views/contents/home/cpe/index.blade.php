@extends('layouts.home.master_h_f_empty')

@section('content')

<?php
date_default_timezone_set('America/Lima');
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
$fecha = date("d-m-Y");
$fechaa = date("m-Y");
?>

<style>
    .bootstrap-datetimepicker-widget{

        z-index: 99999 !import;
    }
</style>

<div id="main-wrapper-auth" class="background-gray-auth">

    <div class="unix-login">
        <div class="container-fluid-auth">
            <div class="row justify-content-center-auth">
                <div class="col-lg-4 card-center min-w">
                    <div class="auth-content card-auth">
                        <div class="login-form-auth">
                            <h4>Comprobante de Pagos Electr&oacute;nicos</h4>
                            <hr>
                            <form method="POST" action="{{ route('cpedoc') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="text-lowecase">Ruc</label>
                                            <input id="ruc" name="ruc" type="text" class="form-control validanumericos" name="ruc" maxlength="11" value="{{ old('ruc') }}" required autofocus placeholder="Ej: 26235842547">
                                            @if ($errors->has('m_total'))
                                                <span class="invalid-feedback">
                                                     <strong>{{ $errors->first('m_total') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="text-lowecase">Tipo de Documento</label>
                                            <select name="tipo_doc" id="tipo_doc" class="selectpicker show-tick form-control" data-live-search-style="begins" data-live-search="true" title="Seleccionar" autocomplete="off">
                                                @foreach($comprobantes as $r)
                                                    <option value="{{$r->id_tipo_doc}}">{{$r->descripcion}}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('tipo_doc'))
                                                <span class="invalid-feedback">
                                                     <strong>{{ $errors->first('tipo_doc') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="text-lowecase">Folio del Documento  (Serie-Correlativo)</label>
                                            <input id="folio_doc" type="text" class="form-control{{ $errors->has('folio_doc') ? ' is-invalid' : '' }}" name="folio_doc" value="{{ old('folio_doc') }}" maxlength="13" required autofocus placeholder="Ej: FXXX-000000">
                                            @if ($errors->has('folio_doc'))
                                                <span class="invalid-feedback">
                                                     <strong>{{ $errors->first('folio_doc') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="text-lowecase">Fecha Emisi&oacute;n</label>
                                            <input type="text" name="start" id="start" class="form-control DatePicker" autocomplete="off" readonly="true" value="{{$fecha}}"/>
                                            @if ($errors->has('f_emision'))
                                                <span class="invalid-feedback">
                                                     <strong>{{ $errors->first('f_emision') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="text-lowecase">Monto Total</label>
                                            <input id="m_total" name="m_total" type="text" class="form-control validanumericos" value="{{ old('m_total') }}" required autofocus placeholder="Ej: 28.01">
                                            @if ($errors->has('m_total'))
                                                <span class="invalid-feedback">
                                                     <strong>{{ $errors->first('m_total') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="g-recaptcha" data-sitekey="{{env('CAPTCHA_KEY')}}"></div>
                                            @if ($errors->has('g-recaptcha'))
                                                <span class="invalid-feedback">
                                                     <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Ver Documento ></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        $('#start').datetimepicker({
            format: 'DD-MM-YYYY',
            locale: 'es-do'
        });
    });
</script>
<script type="text/javascript">
    $(function(){

        $('.validanumericos').keypress(function(e) {
            if(isNaN(this.value + String.fromCharCode(e.charCode)))
                return false;
        })
                .on("cut copy paste",function(e){
                    e.preventDefault();
                });

    });
</script>
@endsection('content')