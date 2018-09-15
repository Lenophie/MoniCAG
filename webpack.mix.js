const mix = require('laravel-mix');

mix.js('resources/js/common.js', 'public/js')
    .js('resources/js/newBorrowing.js', 'public/js')

mix.webpackConfig({
    devtool: "inline-source-map"
});
