@extends('layouts.home.master_h_f_empty')

@section('content')
    <section id="error-page">
        <div class="error-page-inner">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="text-center">
                            <div class="bg-404">
                                <div class="error-image">
                                    <img class="img-responsive" src="images/404.png" alt="">
                                </div>
                            </div>
                            <h2>ERROR INTERNO</h2>
                            <p>La p&aacute;gina que est&aacute; buscando podr&iacute;a haber sido eliminada, o tal vez a cambiado su nombre.</p>
                            <a href="/" class="btn btn-error">REGRESAR A GAL-DA</a>
                            <div class="social-link">
                                <span><a href="#"><i class="fa fa-facebook"></i></a></span>
                                {{--/*<span><a href="#"><i class="fa fa-twitter"></i></a></span>    */--}}
                                {{--/*<span><a href="#"><i class="fa fa-google-plus"></i></a></span>*/--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection('content')
