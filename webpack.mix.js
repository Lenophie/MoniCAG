const mix = require('laravel-mix');

mix.js('resources/js/common.js', 'public/js')
    .js('resources/js/trans.js', 'public/js')
    .js('resources/js/newBorrowing.js', 'public/js')
    .js('resources/js/endBorrowing.js', 'public/js')
    .js('resources/js/borrowingsHistory.js', 'public/js')
    .js('resources/js/viewInventory.js', 'public/js')
    .js('resources/js/editInventory.js', 'public/js')
    .js('resources/js/editUsers.js', 'public/js')
    .js('resources/js/home.js', 'public/js')
    .js('resources/js/account.js', 'public/js')
    .extract(['vue']);

mix.sass('resources/sass/bulma-theming.scss', 'public/css/bulma.css');

mix.styles([
    'resources/css/common.css',
    'resources/css/bulma-override.css',
    'resources/css/footer.css',
], 'public/css/common.css');

mix.styles(['resources/css/index.css'], 'public/css/index.css')
    .styles(['resources/css/new-borrowing.css'], 'public/css/new-borrowing.css')
    .styles(['resources/css/end-borrowing.css'], 'public/css/end-borrowing.css')
    .styles(['resources/css/borrowings-history.css'], 'public/css/borrowings-history.css')
    .styles(['resources/css/view-inventory.css'], 'public/css/view-inventory.css')
    .styles(['resources/css/edit-inventory.css'], 'public/css/edit-inventory.css')
    .styles(['resources/css/edit-users.css'], 'public/css/edit-users.css')
    .styles(['resources/css/light-theme.css'], 'public/css/light-theme.css')
    .styles(['resources/css/dark-theme.css'], 'public/css/dark-theme.css')
    .styles(['resources/css/account.css'], 'public/css/account.css');

mix.copy('resources/css/flag-icon.min.css', 'public/css');
mix.copyDirectory('resources/favicons', 'public/favicons');
mix.copyDirectory('resources/flags', 'public/flags');

mix.options({
    uglify: {
        uglifyOptions: {
            compress: {
                drop_console: true,
            }
        }
    }
});

if (!mix.inProduction()) {
    mix.webpackConfig({
        devtool: "inline-source-map"
    });
} else {
    mix.version();
}
