const mix = require('laravel-mix');
const path = require('path');

mix.alias({
    '@': path.join(__dirname, 'resources/js'),
});

let jsOutputDir = '';
let cssOutputDir = '';

if (mix.inProduction()) {
    if (process.env.MIX_BUILD_PRODUCTION_LIVE == 1) {
        jsOutputDir = 'public/assets/module/dashboard/production/js';
        cssOutputDir = 'public/assets/module/dashboard/production/css';
    }
    else {
        jsOutputDir = 'public/assets/module/dashboard/demo/js';
        cssOutputDir = 'public/assets/module/dashboard/demo/css';
    }
}
else {
    jsOutputDir = 'public/assets/module/dashboard/development/js';
    cssOutputDir = 'public/assets/module/dashboard/development/css';
}

mix.js('resources/js/app-dashboard.js', jsOutputDir).vue({
    runtimeOnly: true
}).postCss('resources/css/app-dashboard.css', cssOutputDir, [
    //
]).setResourceRoot(process.env.MIX_SUBPATH_DOMAIN);