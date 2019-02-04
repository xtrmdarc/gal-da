@extends('layouts.home.master')
@section('metas')
    <meta name="description" content="Gal-Da es un Sistema Para Restaurantes. Software Para Restaurante Gratis. Programa Para Restaurante totalmente Gratis. Aumenta la productivdad de tu restaurante.">
@endsection
@section('content')
<style>
    
</style>
    <section id="home-slider">
        <div class="container">
            <div class="row">
                <div class="main-slider" >
                    <div class="slide-text col-md-4 col-sm-4" >
                        <h1 class="LandingMainHeader" style="margin-top:10px;">Rápido, seguro y confiable </h1>
                        <h2 class="LandingSecondHeader">Organiza y aumenta la productividad de tu restaurante más rápido que nunca</h2>
                        {{--<p>Boudin doner frankfurter pig. Cow shank bresaola pork loin tri-tip tongue venison pork belly meatloaf short loin landjaeger biltong beef ribs shankle chicken andouille.</p>--}}
                        <a href="/register" class="btn btn-common btn-cta-landing-main">Empieza gratis</a>
                    </div>
                    <img src="{{ URL::to('home/images/home/slider/sun.png') }}" class="slider-sun" alt="slider image">
                    <img id="nubes-slider" src="{{ URL::to('home/images/home/slider/nubes.png') }}" class="slider-nubes" alt="slider image">
                
                    <img id="zepellin-slider" src="{{ URL::to('home/images/home/slider/zepellin.png') }}" class="slider-zepellin" alt="slider image">
                    <img src="{{ URL::to('home/images/home/slider/restaurante.png') }}" class="slider-hill" alt="slider image">
                    <img src="{{ URL::to('home/images/home/slider/menu.png') }}" class="slider-house" alt="slider image">
                    
                    <img src="{{ URL::to('home/images/home/slider/birds1.png') }}" class="slider-birds1" alt="slider image">
                    <img src="{{ URL::to('home/images/home/slider/birds2.png') }}" class="slider-birds2" alt="slider image">
                    
                </div>
            </div>
        </div>
        <div class="preloader"><i class="fa fa-sun-o fa-spin"></i></div>
    </section>
    <!--/#home-slider-->
    
    <section id="quees" class="section_landing">
        <div class="container">
            <div class="row">
                <div class="text-center " >
                    <h1 class="LandingMainHeader" style="font-size:4em">Tu Plataforma</h1>                                 
                    <p>Gal-Da es el sistema para restaurantes que te ayuda a automatizar y optimizar los procesos y tareas de tu restaurante, bar, café entre otros. Cuenta con un intuitivo POS (PTV) y herramientas administrativas.
                        </p>  
                    <div class="item active" style="margin-top:2em;">                             
                        <img  src="{{URL::to('https://s3.amazonaws.com/galda-test-picture-empresas/tablero.png')}}" style="width:100%" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
  
    @php
    /*
    <section id="quees" class="section_landing">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <h1 class="title text-center"  >Tu Plataforma</h1>
                    <p>Gal-Da te ayuda a automatizar y optimizar los procesos y tareas de tu restaurante, bar, café entre otros. 
                    </p>
                </div>
                <div class="col-sm-8 text-center " >
                    <div class="item active" style="margin-top:2em;">                             
                        <img  src="{{URL::to('https://s3.amazonaws.com/galda-test-picture-empresas/tablero.png')}}" style="width:100%" alt="">
                    </div>
                </div>
                
            </div>
        </div>
    </section>
    */
    @endphp
    <section id="en_linea_section"  class="section_landing">
        <div class="container">
            <div class="row">
                <div class="col-sm-8" >
                    <video  width="100%" autoplay loop muted playsinline src="{{URL::to('home/images/en_linea.mp4')}}"></video>
                </div>
                <div class="col-sm-4">
                    <h1 class="title text-center ">Pon tu restaurante en línea</h1>
                    <p style="margin-top:20px;">Cada segundo cuenta, por eso Gal-Da te permite sincronizar los <b style="brand-color">pedidos en tiempo real</b> con la cocina.</p>
                    <p>De esta manera, reduces los tiempos de operación y atención. Clientes más felices y más tiempo para invertir en tu restaurante. </p>
                </div>
            </div>
        </div>
    </section>
    <section id="services">
        <div class="container">
            <div class="row">
                <div class="col-sm-4 text-center padding wow fadeIn" data-wow-duration="1000ms" data-wow-delay="300ms">
                    <div class="single-service">
                        <div class="wow scaleIn" data-wow-duration="500ms" data-wow-delay="300ms">
                            <img src="{{ URL::to('home/images/home/monkey-use-landing-icon.jpg') }}" alt="">
                        </div>
                        <h2>Fácil de usar</h2>
                        <p>Es intuitivo y cómodo de utilizar. Desarrollado a medida de la exigencia del mercado gastronómico.</p>
                    </div>
                </div>
                <div class="col-sm-4 text-center padding wow fadeIn" data-wow-duration="1000ms" data-wow-delay="600ms">
                    <div class="single-service">
                        <div class="wow scaleIn" data-wow-duration="500ms" data-wow-delay="600ms">
                            <img src="{{ URL::to('home/images/home/multiple-devices.jpg') }}" alt="">
                        </div>
                        <h2>Online</h2>
                        <p>Completamente en línea. No requiere instalación ni mantenimiento y se puede utilizar desde cualquier lugar.</p>
                    </div>
                </div>
                <div class="col-sm-4 text-center padding wow fadeIn" data-wow-duration="1000ms" data-wow-delay="900ms">
                    <div class="single-service">
                        <div class="wow scaleIn" data-wow-duration="500ms" data-wow-delay="900ms">
                            <img src="{{ URL::to('home/images/home/metrics-landing-icon.png') }}" alt="">
                        </div>
                        <h2>Informes y reportes</h2>
                        <p>Información y estadística útil acerca del desempeño de tu restaurante para tomar decisiones.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 text-center padding wow fadeIn" data-wow-duration="1000ms" data-wow-delay="300ms">
                    <div class="single-service">
                        <div class="wow scaleIn" data-wow-duration="500ms" data-wow-delay="300ms">
                            <img src="{{ URL::to('home/images/home/zepelling-gratis.png') }}" alt="">
                        </div>
                        <h2>Gratis</h2>
                        <p>Prueba nuestro plan completamente gratis con calidad empresarial.</p>
                    </div>
                </div>
                <div class="col-sm-4 text-center padding wow fadeIn" data-wow-duration="1000ms" data-wow-delay="600ms">
                    <div class="single-service">
                        <div class="wow scaleIn" data-wow-duration="500ms" data-wow-delay="600ms">
                            <img src="{{ URL::to('home/images/home/relax-movil-landing-icon.png') }}" alt="">
                        </div>
                        <h2>Móvil</h2>
                        <p>Controla y monitorea las operaciones de tu restaurante desde cualquier parte con tu dispositivo móvil.</p>
                    </div>
                </div>
                <div class="col-sm-4 text-center padding wow fadeIn" data-wow-duration="1000ms" data-wow-delay="900ms">
                    <div class="single-service">
                        <div class="wow scaleIn" data-wow-duration="500ms" data-wow-delay="900ms">
                            <img src="{{ URL::to('home/images/home/save-time-landing-icon.png') }}" alt="">
                        </div>
                        <h2>Ahorra tiempo</h2>
                        <p>Aumenta tu productividad optimizando los tiempos de las operaciones de tu negocio.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/#services-->
    
    <section id="action" class="responsive">
        <div class="vertical-center">
            <div class="container">
                <div class="row">
                    <div class="action take-tour">
                        <div class="col-sm-7 wow fadeInLeft" data-wow-duration="500ms" data-wow-delay="300ms">
                            <h1 class="title">Módulo de delivery</h1>
                            <p>Incrementa tus ventas implementando hoy mismo el delivery en tu restaurante.</p>
                        </div>
                        <div class="col-sm-5 text-center wow fadeInRight" data-wow-duration="500ms" data-wow-delay="300ms">
                            <div class="tour-button">
                                <a href="/register" class="btn btn-common">LO QUIERO</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/#action-->

    <section id="features" style="margin-top:40px;">
        <div class="container" >
            <div class="row">
                <div class="single-features">
                    <div class="col-sm-5 wow fadeInLeft" data-wow-duration="500ms" data-wow-delay="300ms" style="padding:0px;">
                        <img src="{{ URL::to('home/images/home/galda-app.png') }}" class="img-responsive"  alt="">
                    </div>
                    <div class="col-sm-6 wow fadeInRight" style="margin-top:0px;" data-wow-duration="500ms" data-wow-delay="300ms">
                        <h2>Más rápido imposible.</h2>
                        <P>Ahorra tiempo empoderando a tus trabajadores dándoles acceso a herramientas que potencian su productividad.</P>
                    </div>
                </div>
                @php
                /*
                <div class="single-features">
                    <div class="col-sm-6 col-sm-offset-1 align-right wow fadeInLeft" data-wow-duration="500ms" data-wow-delay="300ms">
                        <h2>Built for the Responsive Web</h2>
                        <P>Mollit eiusmod id chuck turducken laboris meatloaf pork loin tenderloin swine. Pancetta excepteur fugiat strip steak tri-tip. Swine salami eiusmod sint, ex id venison non. Fugiat ea jowl cillum meatloaf.</P>
                    </div>
                    <div class="col-sm-5 wow fadeInRight" data-wow-duration="500ms" data-wow-delay="300ms">
                        <img src="{{ URL::to('home/images/home/image2.png') }}" class="img-responsive" alt="">
                    </div>
                </div>
                <div class="single-features">
                    <div class="col-sm-5 wow fadeInLeft" data-wow-duration="500ms" data-wow-delay="300ms">
                        <img src="{{ URL::to('home/images/home/image3.png') }}" class="img-responsive" alt="">
                    </div>
                    <div class="col-sm-6 wow fadeInRight" data-wow-duration="500ms" data-wow-delay="300ms">
                        <h2>Experienced and Enthusiastic</h2>
                        <P>Ut officia cupidatat anim excepteur fugiat cillum ea occaecat rump pork chop tempor. Ut tenderloin veniam commodo. Shankle aliquip short ribs, chicken eiusmod exercitation shank landjaeger spare ribs corned beef.</P>
                    </div>
                </div>
                */
                @endphp
            </div>
        </div>
    </section>
    <!--/#features-->

    <section id="clients">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="clients text-center wow fadeInUp" data-wow-duration="500ms" data-wow-delay="300ms">
                        <p><img src="{{ URL::to('home/images/home/clients.png') }}" class="img-responsive" alt=""></p>
                        <h1 class="title">Clientes Felices</h1>
                        <p>Únete a nuestro grupo de cliente embajadores. <br> Y aprovecha grandes beneficios </p>
                    </div>
                    @php
                        /*
                        <div class="clients-logo wow fadeIn" data-wow-duration="1000ms" data-wow-delay="600ms">
                            <div class="col-xs-3 col-sm-2">
                                <a href="#"><img src="{{ URL::to('home/images/home/client1.png') }}" class="img-responsive" alt=""></a>
                            </div>
                            <div class="col-xs-3 col-sm-2">
                                <a href="#"><img src="{{ URL::to('home/images/home/client2.png') }}" class="img-responsive" alt=""></a>
                            </div>
                            <div class="col-xs-3 col-sm-2">
                                <a href="#"><img src="{{ URL::to('home/images/home/client3.png') }}" class="img-responsive" alt=""></a>
                            </div>
                            <div class="col-xs-3 col-sm-2">
                                <a href="#"><img src="{{ URL::to('home/images/home/client4.png') }}" class="img-responsive" alt=""></a>
                            </div>
                            <div class="col-xs-3 col-sm-2">
                                <a href="#"><img src="{{ URL::to('home/images/home/client5.png') }}" class="img-responsive" alt=""></a>
                            </div>
                            <div class="col-xs-3 col-sm-2">
                                <a href="#"><img src="{{ URL::to('home/images/home/client6.png') }}" class="img-responsive" alt=""></a>
                            </div>
                        </div>    
                        */
                    @endphp
                    
                </div>
            </div>
        </div>
    </section>
    <!--/#clients-->
    <script src="{{URL::to('home/js/Pages/Landing_page.js')}}"></script>
@endsection('content')