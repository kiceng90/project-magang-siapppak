const mix = require('laravel-mix');
const path = require('path');

mix.alias({
  '@': path.join(__dirname, 'resources/js'),
});

let jsDashboardOutputDir = '';
let cssDashboardOutputDir = '';
let jsLandingOutputDir = '';
let cssLandingOutputDir = '';

if (mix.inProduction()) {
  if (process.env.MIX_BUILD_PRODUCTION_LIVE == 1) {
    jsDashboardOutputDir = 'public/assets/module/dashboard/production/js';
    cssDashboardOutputDir = 'public/assets/module/dashboard/production/css';
    jsLandingOutputDir = 'public/assets/module/landing/production/js';
    cssLandingOutputDir = 'public/assets/module/landing/production/css';
  }
  else {
    jsDashboardOutputDir = 'public/assets/module/dashboard/demo/js';
    cssDashboardOutputDir = 'public/assets/module/dashboard/demo/css';
    jsLandingOutputDir = 'public/assets/module/landing/demo/js';
    cssLandingOutputDir = 'public/assets/module/landing/demo/css';
  }
}
else {
  jsDashboardOutputDir = 'public/assets/module/dashboard/development/js';
  cssDashboardOutputDir = 'public/assets/module/dashboard/development/css';
  jsLandingOutputDir = 'public/assets/module/landing/development/js';
  cssLandingOutputDir = 'public/assets/module/landing/development/css';
}

mix.js('resources/js/app-dashboard.js', jsDashboardOutputDir).vue({
  runtimeOnly: true
}).postCss('resources/css/app-dashboard.css', cssDashboardOutputDir, [
  //
]).setResourceRoot(process.env.MIX_SUBPATH_DOMAIN);

mix.js('resources/js/app-landing.js', jsLandingOutputDir).vue({
  runtimeOnly: true
}).postCss('resources/css/app-landing.css', cssLandingOutputDir, [
  //
]).setResourceRoot(process.env.MIX_SUBPATH_DOMAIN);

mix.disableNotifications();

// Tambahkan konfigurasi watchOptions untuk polling
mix.webpackConfig({
  watchOptions: {
    poll: 1000, // Memeriksa perubahan setiap 1000ms
    aggregateTimeout: 300, // Jeda sebelum melakukan kompilasi ulang
  },
});
