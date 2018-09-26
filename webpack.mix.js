const mix = require('laravel-mix');

mix.js('resources/js/common.js', 'public/js')
    .js('resources/js/newBorrowing.js', 'public/js')
    .js('resources/js/endBorrowing.js', 'public/js')
    .js('resources/js/viewInventory.js', 'public/js');

mix.webpackConfig({
    devtool: "inline-source-map"
});
