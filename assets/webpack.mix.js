const mix = require('laravel-mix');
const yargs = require('yargs');
const argv = yargs(process.argv.slice(2))
  .options({
    openBrowser: {type: 'boolean', default: false},
  })
  .parseSync();

const root = '..';
const vendor = `${root}/vendor`;
const src = 'src';
const dist = 'dist';

mix

  /**
   *==========================================================================
   * Output directory
   *==========================================================================
   *
   *
   *
   */
  .setPublicPath('dist')

  /**
   *==========================================================================
   * Sourcemaps
   *==========================================================================
   *
   *
   *
   */
  .sourceMaps(true, 'eval-source-map', 'source-map')

  /**
   *==========================================================================
   * Versioning
   *==========================================================================
   *
   *
   *
   */
  .version()

  /**
   *==========================================================================
   * Browsersync
   *==========================================================================
   *
   *
   *
   */
  .browserSync({
    proxy: 'leonidas.test',
    open: argv.open ?? false,
    notify: false,
    logLevel: 'debug',
    files: [
      'dist/**/*.js',
      'dist/**/*.css',
      '../app/**/*.php',
      '../boot/**/*.php',
      '../theme/**/*.php',
      '../config/**/*.php',
      '../views/**/*.twig',
    ],
  })

  /**
   *==========================================================================
   * Javascript
   *==========================================================================
   *
   *
   *
   */
  .js('src/js/index.js', 'dist/js/leonidas.js')
  // .autoload({jquery: ['$', 'window.jQuery']})
  .extract()

  /**
   *==========================================================================
   * Typescript
   *==========================================================================
   *
   *
   *
   */
  // .ts('src/ts/index.ts', 'dist/js/leonidas.js')
  // .autoload({jquery: ['$', 'window.jQuery']})
  // .extract()

  /**
   *==========================================================================
   * Sass
   *==========================================================================
   *
   *
   *
   */
  .sass('src/scss/main.scss', 'dist/css/leonidas.css', {
    sassOptions: {
      outputStyle: 'expanded',
    },
  })

  /**
   *==========================================================================
   * Copies
   *==========================================================================
   *
   *
   *
   */
  // saveyour
  .copy(
    ['../vendor/webtheory/saveyour/assets/dist/saveyour.js'],
    'dist/lib/saveyour/'
  )
  // select2
  .copy(
    [
      './node_modules/select2/dist/css/select2.min.css',
      './node_modules/select2/dist/js/select2.full.min.js',
    ],
    'dist/lib/select2/'
  )
  // choices
  .copy(
    [
      './node_modules/choices.js/public/assets/scripts/choices.min.js',
      './node_modules/choices.js/public/assets/styles/choices.min.css',
    ],
    'dist/lib/choices/'
  )
  // trix
  .copy(
    ['./node_modules/trix/dist/trix.js', './node_modules/trix/dist/trix.css'],
    'dist/lib/trix/'
  )

  /**
   *==========================================================================
   * Options
   *==========================================================================
   *
   *
   *
   */
  .options({
    processCssUrls: false,
    postCss: [require('tailwindcss')],
    // imgLoaderOptions: {},
  })

  /**
   *==========================================================================
   * Webpack
   *==========================================================================
   *
   *
   *
   */
  .webpackConfig({
    stats: {
      children: true,
    },
  });
