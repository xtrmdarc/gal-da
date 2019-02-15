<header id="header">
    {{--<div class="container">
        <div class="row">
            <div class="col-sm-12 overflow">
                <div class="social-icons pull-right">
                    <ul class="nav nav-pills">
                        <li><a href=""><i class="fa fa-facebook"></i></a></li>
                        <li><a href=""><i class="fa fa-twitter"></i></a></li>
                        <li><a href=""><i class="fa fa-google-plus"></i></a></li>
                        <li><a href=""><i class="fa fa-dribbble"></i></a></li>
                        <li><a href=""><i class="fa fa-linkedin"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>--}}
    <div class="navbar navbar-inverse" role="banner">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a class="navbar-brand" href="/">
                    <img id="logo-home" class="image-responsive" src="{{ URL::to('home/images/logo-1.png') }}" alt="logo">
                    <h1>Gal-Da, Software para restaurantes gratis</h1>
                </a>

            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li {!! Route::currentRouteName() == '' ? 'class="active"' : '' !!}><a href="/">Inicio</a></li>
                    <li><a href="#quees">Que es</a>
                    </li>
                    @if (Auth::check())
                        <li>
                        </li>
                    @else
                        <li {!! Route::currentRouteName() == 'prices' ? 'class="active"' : '' !!}><a href="{{ route('prices') }}">Precios</a>
                        </li>
                    @endif
                    <li><a href="#footer">Contacto</a>
                    </li>
                    @if (Auth::check())
                        @php
                            $idPlan = \Auth::user()->plan_id;
                            if($idPlan == 1){
                        @endphp
                            <li><a href="{{ route('tableroF') }}"><b>IR AL TABLERO</b></a></li>
                        @php
                            } else {
                        @endphp
                            <li><a href="{{ route('tablero') }}"><b>IR AL TABLERO</b></a></li>
                        @php
                            }
                        @endphp
                    @else
                     <li {!! Route::currentRouteName() == 'login' ? 'class="active"' : '' !!}><a href="{{ route('login') }}">Iniciar Sesi&oacute;n</a></li>
                     <li {!! Route::currentRouteName() == 'register' ? 'class="active"' : '' !!}><a class="btn btn-cta-landing-main" style="margin: 0px;color:white;font-weight:700;" href="{{ route('register') }}">Empieza YA</a></li>
                    @endif
                </ul>
            </div>
            @php
                /*
                <div class="search">
                    <form role="form">
                        <i class="fa fa-search"></i>
                        <div class="field-toggle">
                            <input type="text" class="search-form" autocomplete="off" placeholder="Search">
                        </div>
                    </form>
                </div>
                */
            @endphp
            
        </div>
    </div>
</header>
<!--/#header-->

