const mix = require('laravel-mix');
const path = require('path');

mix.alias({
    '@': path.join(__dirname, 'resources/js'),
});

let jsOutputDir = '';
let cssOutputDir = '';

if (mix.inProduction()) {
    if (process.env.MIX_BUILD_PRODUCTION_LIVE == 1) {
        jsOutputDir = 'public/assets/module/landing/production/js';
        cssOutputDir = 'public/assets/module/landing/production/css';
    }
    else {
        jsOutputDir = 'public/assets/module/landing/demo/js';
        cssOutputDir = 'public/assets/module/landing/demo/css';
    }
}
else {
    jsOutputDir = 'public/assets/module/landing/development/js';
    cssOutputDir = 'public/assets/module/landing/development/css';
}

mix.js('resources/js/app-landing.js', jsOutputDir).vue({
    runtimeOnly: true
}).postCss('resources/css/app-landing.css', cssOutputDir, [
    //
]).setResourceRoot(process.env.MIX_SUBPATH_DOMAIN);