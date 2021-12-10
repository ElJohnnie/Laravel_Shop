const mix = require("laravel-mix");

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

mix.js("resources/js/app.js", "public/js").sass(
    "resources/sass/app.scss",
    "public/css"
);

mix.copy("resources/js/all.js", "public/js")
    .copy("resources/js/checkout.js", "public/js")
    .copy("resources/js/vanilla.js", "public/js")
    .copy("resources/js/owl.carousel.min.js", "public/js")
    .copy("resources/js/map.js", "public/js")
    .copy("resources/js/main.js", "public/js")
    .copy("resources/js/jquery.zoom.min.js", "public/js")
    .copy("resources/js/jquery.slicknav.min.js", "public/js")
    .copy("resources/js/jquery.nicescroll.min.js", "public/js")
    .copy("resources/js/jquery-ui.min.js", "public/js")
    .copy("resources/js/bannerPreview.js", "public/js")
    .copy("resources/js/cart.js", "public/js")
    .copy("resources/js/control-panel.js", "public/js")
    .copy("resources/js/checkout_address.js", "public/js")
    .copy("resources/js/checkout_shipping.js", "public/js")
    .copy("resources/js/checkout_payment.js", "public/js")
    .copy("resources/js/cart.js", "public/js")
    .copy("resources/js/favorites.js", "public/js")
    .copy("resources/js/sales.js", "public/js");
