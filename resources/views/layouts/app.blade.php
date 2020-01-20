<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Torneo Arena 2020 - Inicio</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/pagina.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/pagina.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <header id="header">
            <div class="container">
                <div id="logo" class="pull-left d-none">
                    <a href="#intro" class="scrollto"><img src="{{ asset('img/logo-arena.png') }}" alt="" title="" height="40"></a>
                </div>

                <nav id="nav-menu-container">
                    <ul class="nav-menu">
                    <li class="menu-active"><a href="{{ request()->is('/') ? '#intro' : url('/intro') }}">INICIO</a></li>
                    <li><a href="{{ request()->is('/') ? '#inscripciones' : url('/#inscripciones') }}">INSCRÍBETE</a></li>
                    <li><a href="{{ request()->is('/') ? '#galeria' : url('/#galeria') }}">GALERÍA</a></li>
                    <li><a href="{{ request()->is('/') ? '#contacto' : url('/#contacto') }}">CONTACTO</a></li>
                    <li><a href="https://www.instagram.com/torneoarena/?hl=es-la" target="_blank" class="padding-instagram"><i class="fa fa-instagram fa-2x"></i></a></li>
                    <li class="buy-tickets"><a href="javascript:void(0)">BASES</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        @yield('content')

        <footer id="footer">
            <div class="footer-top">
              <div class="container">
                <div class="row">
                  <div class="col-lg-12 col-md-12">
                        <div class="social-links text-center">
                            <a href="https://www.instagram.com/torneoarena/?hl=es-la" target="_blank" class="instagram"><i class="fa fa-instagram"></i></a>
                        </div>
                        <div class="copyright">
                            &copy;  <strong>Torneo Arena</strong>. Todos los derechos reservados.
                        </div>
                  </div>
                </div>
              </div>
            </div>
        </footer>

    </div>
</body>
</html>
