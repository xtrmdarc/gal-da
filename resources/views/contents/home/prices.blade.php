@extends('layouts.home.master')

@section('content')

    <div class="price-tables">
        @component('components.home.register-form.register-form-lhp-step-plan', [
            'class_active' => 'active'
                ])
        @endcomponent
    </div>

@endsection('content')