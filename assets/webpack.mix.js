const mix = require('laravel-mix');

/**
 * Settings
 */
mix
  .setPublicPath('dist')
  .setResourceRoot('src')
  .browserSync('leonidas.test')
  .sourceMaps(true, 'eval-source-map', 'source-map')
  .version()
  .options({
    processCssUrls: false,
    postCss: [require('tailwindcss')],
  });

/**
 * Styles
 */
mix.sass('src/scss/main.scss', 'css/leonidas.css', {
  sassOptions: {
    outputStyle: 'expanded',
  },
});

/**
 * Scripts
 */
mix
  .js('src/js/index.js', 'js/leonidas.js')
  // .autoload({jquery: ['$', 'window.jQuery']})
  .extract();

/**
 * Direct Copies
 */
mix
  // saveyour
  .copy(
    ['../vendor/webtheory/saveyour/assets/dist/saveyour.js'],
    'dist/lib/saveyour/',
  )
  // select2
  .copy(
    [
      './node_modules/select2/dist/css/select2.min.css',
      './node_modules/select2/dist/js/select2.full.min.js',
    ],
    'dist/lib/select2/',
  )
  // choices
  .copy(
    [
      './node_modules/choices.js/public/assets/scripts/choices.min.js',
      './node_modules/choices.js/public/assets/styles/choices.min.css',
    ],
    'dist/lib/choices/',
  )
  // trix
  .copy(
    ['./node_modules/trix/dist/trix.js', './node_modules/trix/dist/trix.css'],
    'dist/lib/trix/',
  );
