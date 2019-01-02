@extends('layouts.home.master')

@section('content')

    <form
        id="register-form-galda"
        class="register-form"
        method="post"
        action="{{ route('web.auth.register.store') }}"
            >
        {{ csrf_field() }}
        <hr>
        <header class="register-form-nav">
            <ol class="register-phases card-center">
                <li class="site-color-account active">
                    <button type="button" data-index="1">Crear una cuenta</button>
                </li>
                <li class="site-color-plan">
                    <button id="btn-nav-plan" type="button" data-index="2" disabled>Seleccion un Plan</button>
                </li>
                <li class="site-color-payment">
                    <button id="btn-nav-payment" type="button" data-index="3" disabled>Metodo de Pago</button>
                </li>
            </ol>
        </header>

        @component('components.home.register-form.register-form-step-account', [
            'class_active' => 'active'
        ])

        @endcomponent
        @component('components.home.register-form.register-form-lhp-step-plan', [

        ])

        @endcomponent
        @component('components.home.register-form.register-form-step-payment', [

        ])
        @endcomponent
    </form>
@endsection('content')