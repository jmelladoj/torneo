@extends('layouts.app')

@section('content')
    <section id="intro">
        <div class="intro-container wow fadeIn">
            <h1 class="mb-4 pb-0">{{ $titulo }}</h1>
            <p class="mb-4 pb-0">{!! $texto !!}</p>
            <img src="{{ asset('img/logo-arena.png') }}" class="img-fluid mb-5 img-max-height"/>
            <a href="{{ url('/') }}" class="about-btn scrollto">Volver a página principal</a>
        </div>
    </section>
@endsection
