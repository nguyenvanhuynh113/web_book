const mix = require('laravel-mix');
mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .copy('node_modules/owl.carousel/dist/assets/owl.carousel.min.css', 'public/css')
    .copy('node_modules/owl.carousel/dist/assets/owl.theme.default.min.css', 'public/css')
    .copy('node_modules/owl.carousel/dist/owl.carousel.min.js', 'public/js');

