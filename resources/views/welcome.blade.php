@extends('layouts.app')

@section('content')
    <section id="intro">
        <div class="intro-container wow fadeIn">
            <img src="{{ asset('img/logo-arena.png') }}" class="img-fluid mb-5" />
            <a href="#inscripciones" class="about-btn scrollto">Inscripciones</a>
        </div>
    </section>

    <categorias-inscripcion></categorias-inscripcion>

    <section id="galeria" class="wow fadeInUp section-with-bg">

        <div class="container">
          <div class="section-header">
            <h2>Galería</h2>
            <p>Revive algunos momento de lo que fue Arena 2019</p>
          </div>
        </div>

        <div class="owl-carousel gallery-carousel">
            <a href="{{ asset('pagina/img/gallery/1.jpg') }}" class="venobox" data-gall="gallery-carousel"><img src="{{ asset('pagina/img/gallery/1.jpg') }}" alt=""></a>
            <a href="{{ asset('pagina/img/gallery/2.jpg') }}" class="venobox" data-gall="gallery-carousel"><img src="{{ asset('pagina/img/gallery/2.jpg') }}" alt=""></a>
            <a href="{{ asset('pagina/img/gallery/3.jpg') }}" class="venobox" data-gall="gallery-carousel"><img src="{{ asset('pagina/img/gallery/3.jpg') }}" alt=""></a>
            <a href="{{ asset('pagina/img/gallery/4.jpg') }}" class="venobox" data-gall="gallery-carousel"><img src="{{ asset('pagina/img/gallery/4.jpg') }}" alt=""></a>
            <a href="{{ asset('pagina/img/gallery/5.jpg') }}" class="venobox" data-gall="gallery-carousel"><img src="{{ asset('pagina/img/gallery/5.jpg') }}" alt=""></a>
            <a href="{{ asset('pagina/img/gallery/6.jpg') }}" class="venobox" data-gall="gallery-carousel"><img src="{{ asset('pagina/img/gallery/6.jpg') }}" alt=""></a>
            <a href="{{ asset('pagina/img/gallery/7.jpg') }}" class="venobox" data-gall="gallery-carousel"><img src="{{ asset('pagina/img/gallery/7.jpg') }}" alt=""></a>
            <a href="{{ asset('pagina/img/gallery/8.jpg') }}" class="venobox" data-gall="gallery-carousel"><img src="{{ asset('pagina/img/gallery/8.jpg') }}" alt=""></a>
            <a href="{{ asset('pagina/img/gallery/9.jpg') }}" class="venobox" data-gall="gallery-carousel"><img src="{{ asset('pagina/img/gallery/9.jpg') }}" alt=""></a>
            <a href="{{ asset('pagina/img/gallery/10.jpg') }}" class="venobox" data-gall="gallery-carousel"><img src="{{ asset('pagina/img/gallery/10.jpg') }}" alt=""></a>
            <a href="{{ asset('pagina/img/gallery/11.jpg') }}" class="venobox" data-gall="gallery-carousel"><img src="{{ asset('pagina/img/gallery/11.jpg') }}" alt=""></a>
            <a href="{{ asset('pagina/img/gallery/12.jpg') }}" class="venobox" data-gall="gallery-carousel"><img src="{{ asset('pagina/img/gallery/12.jpg') }}" alt=""></a>
            <a href="{{ asset('pagina/img/gallery/13.jpg') }}" class="venobox" data-gall="gallery-carousel"><img src="{{ asset('pagina/img/gallery/13.jpg') }}" alt=""></a>
            <a href="{{ asset('pagina/img/gallery/14.jpg') }}" class="venobox" data-gall="gallery-carousel"><img src="{{ asset('pagina/img/gallery/14.jpg') }}" alt=""></a>
            <a href="{{ asset('pagina/img/gallery/15.jpg') }}" class="venobox" data-gall="gallery-carousel"><img src="{{ asset('pagina/img/gallery/15.jpg') }}" alt=""></a>
            <a href="{{ asset('pagina/img/gallery/16.jpg') }}" class="venobox" data-gall="gallery-carousel"><img src="{{ asset('pagina/img/gallery/16.jpg') }}" alt=""></a>
            <a href="{{ asset('pagina/img/gallery/17.jpg') }}" class="venobox" data-gall="gallery-carousel"><img src="{{ asset('pagina/img/gallery/17.jpg') }}" alt=""></a>
        </div>
    </section>


    <section id="contacto" class="wow fadeInUp">

        <div class="container">

          <div class="section-header">
            <h2>Contáctanos</h2>
            <p>¿Tienes una duda?</p>
          </div>

          <div class="form">
            <div id="sendmessage">Tu mensaje ha sido enviado. ¡Gracias!</div>
            <div id="errormessage"></div>
            <form action="" method="post" role="form" class="contactForm">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Ingresa tu nombre" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
                  <div class="validation"></div>
                </div>
                <div class="form-group col-md-6">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Ingresa tu correo" data-rule="email" data-msg="Please enter a valid email" />
                  <div class="validation"></div>
                </div>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Asunto de tu mensaje" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" />
                <div class="validation"></div>
              </div>
              <div class="form-group">
                <textarea class="form-control" name="message" rows="5" data-rule="required" data-msg="Escríbe tu mensaje aquí ..." placeholder="Escríbe tu mensaje aquí ..."></textarea>
                <div class="validation"></div>
              </div>
              <div class="text-center"><button type="submit">Enviar mensaje</button></div>
            </form>
          </div>

        </div>
    </section>

    <section id="venue" class="section-with-bg wow fadeInUp">

        <div class="container-fluid">

          <div class="section-header">
            <h2>¿Dónde se realizara?</h2>
            <p>Lugar del torneo</p>
          </div>

          <div class="row no-gutters">
            <div class="col-lg-12 venue-map">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3198.097790347796!2d-73.11099108520769!3d-36.7202125799651!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x96683575023181e1%3A0xe66acd3ddfd11308!2sColiseo+La+Tortuga!5e0!3m2!1ses!2scl!4v1552062384693" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
          </div>

        </div>

    </section>

    <section id="sponsors" class="wow fadeInUp">
        <div class="container">
          <div class="section-header">
            <h2>Sponsors</h2>
          </div>
        </div>

        <div class="row text-center mb-5">
            <div class="col-4">
                <img src="{{ asset('pagina/img/sponsors/1.png') }} " class="img-fluid" alt="">
            </div>
            <div class="col-4">
                <img src="{{ asset('pagina/img/sponsors/3.png') }} " class="img-fluid" alt="">
            </div>
            <div class="col-4">
                <img src="{{ asset('pagina/img/sponsors/2.png') }} " class="img-fluid" alt="">
            </div>
        </div>

        <div class="row text-center">
          <div class="col-6">
            <img src="{{ asset('pagina/img/sponsors/4.png') }} " class="img-fluid" alt="">
          </div>
          <div class="col-6">
            <img src="{{ asset('pagina/img/sponsors/3.jpg') }} " class="img-fluid" alt="">
          </div>
        </div>

    </section>

@endsection
