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

if (!mix.inProduction()) {
    mix.sourceMaps();
}

mix.sass('resources/sass/app.scss', 'public/assets/admin/app.css');
mix.sass('resources/sass/vendor.scss', 'public/assets/admin/vendor.css');

mix.sass('resources/sass/web/app.scss', 'public/assets/web/app.css');
mix.sass('resources/sass/web/vendor.scss', 'public/assets/web/vendor.css');


// Keep at the bottom
mix.js('resources/js/app.js', 'public/assets/app.js')
	.extract([
		'vue', 'vuejs-dialog', 'axios', 'jquery',
		'@fortawesome/fontawesome-free', 
		'toastr', 
		'bootstrap', 'bootstrap-daterangepicker', 'admin-lte', 
		'flatpickr', 'selectize', 'vue-template-compiler', 'vue2-selectize',
		'chart.js', 'swiper',
		'moment',
	]);

mix.version();
