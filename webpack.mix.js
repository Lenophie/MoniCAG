const mix = require('laravel-mix');

mix.js('resources/js/common.js', 'public/js')
    .js('resources/js/newBorrowing.js', 'public/js')
    .js('resources/js/endBorrowing.js', 'public/js')
    .js('resources/js/viewInventory.js', 'public/js')
    .js('resources/js/editInventory.js', 'public/js')
    .js('resources/js/editUsers.js', 'public/js');

mix.copy('resources/css/index.css', 'public/css')
    .copy('resources/css/new-borrowing.css', 'public/css')
    .copy('resources/css/end-borrowing.css', 'public/css')
    .copy('resources/css/borrowings-history.css', 'public/css')
    .copy('resources/css/view-inventory.css', 'public/css')
    .copy('resources/css/edit-inventory.css', 'public/css')
    .copy('resources/css/edit-users.css', 'public/css');

mix.copyDirectory('resources/favicons', 'public/favicons');

mix.webpackConfig({
    devtool: "inline-source-map"
});
