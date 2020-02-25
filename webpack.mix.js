const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js').version()
   .sass('resources/sass/app.scss', 'public/css').version();

mix.scripts([
   'public/assets/node_modules/jquery/jquery-3.2.1.min.js',
   'public/assets/node_modules/popper/popper.min.js',
   'public/assets/node_modules/bootstrap/dist/js/bootstrap.min.js',
   'public/js/perfect-scrollbar.jquery.min.js',
   'public/js/waves.js',
   'public/js/sidebarmenu.js',
   'public/js/custom.js',
   'public/assets/node_modules/raphael/raphael-min.js',
   'public/assets/node_modules/jquery-sparkline/jquery.sparkline.min.js'
], 'public/js/intranet.js').version();


mix.styles([
    'public/pagina/lib/bootstrap/css/bootstrap.min.css',
    'public/pagina/lib/font-awesome/css/font-awesome.min.css',
    'public/pagina/lib/animate/animate.min.css',
    'public/pagina/lib/venobox/venobox.css',
    'public/pagina/lib/owlcarousel/assets/owl.carousel.min.css',
    'public/pagina/css/style.css',
 ], 'public/css/pagina.css').version()
 .scripts([
    'public/pagina/lib/jquery/jquery-migrate.min.js',
    'public/pagina/lib/bootstrap/js/bootstrap.bundle.min.js',
    'public/pagina/lib/easing/easing.min.js',
    'public/pagina/lib/superfish/hoverIntent.js',
    'public/pagina/lib/superfish/superfish.min.js',
    'public/pagina/lib/wow/wow.min.js',
    'public/pagina/lib/venobox/venobox.min.js',
    'public/pagina/lib/owlcarousel/owl.carousel.min.js',
    'public/pagina/contactform/contactform.js',
    'public/pagina/js/main.js'
 ], 'public/js/pagina.js').version();

