@extends('layouts.home.master')

@section('content')

    <section id="page-breadcrumb">
        <div class="vertical-center sun">
            <div class="container">
                <div class="row">
                    <div class="action">
                        <div class="col-sm-12">
                            <h1 class="title">Centro de Ayuda</h1>
                            <p>Aqui encontraras la ayuda necesaria de Gal-Da</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="shortcodes">
        <div class="container">
            <div id="feature-container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-header"></h2>
                    </div>
                    <div class="col-sm-3 wow fadeInUp" data-wow-duration="500ms" data-wow-delay="300ms">
                        <a href="{{route('primerosPasos')}}" class="color-a-help-center">
                            <div class="feature-inner">
                                <div class="icon-wrapper">
                                    <i class="fa fa-2x fa-envelope-o"></i>
                                </div>
                                <h2>Primeros Pasos</h2>
                                <p>Eres nuevo? Empieza por aqui!</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-3 wow fadeInUp" data-wow-duration="500ms" data-wow-delay="600ms">
                        <a href="">
                            <div class="feature-inner">
                                <div class="icon-wrapper">
                                    <i class="fa fa-2x fa-heart-o"></i>
                                </div>
                                <h2>Guia de Usabilidad</h2>
                                <p>Sigues nuestros pasos para que todo vaya bien</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-3 wow fadeInUp" data-wow-duration="500ms" data-wow-delay="900ms">
                        <a href="{{route('manual_galda')}}">
                            <div class="feature-inner">
                                <div class="icon-wrapper">
                                    <i class="fa fa-2x fa-star-o"></i>
                                </div>
                                <h2>Manual del Gal-Da</h2>
                                <p>Encuentra el detalle de cada m&oacute;dulo segun tu Plan</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-3 wow fadeInUp" data-wow-duration="500ms" data-wow-delay="1200ms">
                        <a href="">
                            <div class="feature-inner">
                                <div class="icon-wrapper">
                                    <i class="fa fa-2x fa-comments-o"></i>
                                </div>
                                <h2>Preguntas Frecuentes</h2>
                                <p>Aqui encontraras las respuestas a tus preguntas con Gal-Da</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3 wow fadeInUp" data-wow-duration="500ms" data-wow-delay="300ms">
                        <div class="feature-inner">
                        </div>
                    </div>
                    <div class="col-sm-3 wow fadeInUp" data-wow-duration="500ms" data-wow-delay="600ms">
                        <a href="">
                            <div class="feature-inner">
                                <div class="icon-wrapper">
                                    <i class="fa fa-2x fa-heart-o"></i>
                                </div>
                                <h2>TIPS de Seguridad</h2>
                                <p>Indicaciones a tener en cuenta</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-3 wow fadeInUp" data-wow-duration="500ms" data-wow-delay="900ms">
                        <a href="">
                            <div class="feature-inner">
                                <div class="icon-wrapper">
                                    <i class="fa fa-2x fa-star-o"></i>
                                </div>
                                <h2>Que hay de nuevo?</h2>
                                <p>Enterate de nuestras ultimas novedades en Gal-Da</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-3 wow fadeInUp" data-wow-duration="500ms" data-wow-delay="1200ms">
                        <div class="feature-inner">
                        </div>
                    </div>
                </div>
            </div><!--/#feature-container-->
            <hr>
        </div>
    </section>

@endsection('content')