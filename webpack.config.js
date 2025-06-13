const webpack = require('webpack');
const mix = require('laravel-mix');


mix.webpackConfig({
    plugins: [
        new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/),
    ]
});
