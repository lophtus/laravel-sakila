const mix = require('laravel-mix');

mix.setPublicPath('public');

mix.webpackConfig({
  devtool: 'source-map',
  resolve: {
    extensions: ['.js', '.vue', '.json'],
    alias: {
      '@': __dirname + '/resources/js/admin'
    },
  }
});

mix.js('resources/js/admin/app.js', 'public/js/admin.js')
  .copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/fonts')
  .sass('resources/sass/admin/app.scss', 'public/css/admin.css');
