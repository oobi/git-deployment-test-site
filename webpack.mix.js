const mix = require('laravel-mix');

mix.setPublicPath('public');
mix.sass('resources/sass/app.scss', 'css');

mix.options({
    processCssUrls: false,
});
