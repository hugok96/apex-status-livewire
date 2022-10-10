const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'js').setPublicPath('public/');
mix.sass('resources/css/app.sass', 'css').setPublicPath('public/');
