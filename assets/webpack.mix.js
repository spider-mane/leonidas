const mix = require('laravel-mix');
const yargs = require('yargs');
const dotenv = require('dotenv');
const sass = require('sass-embedded');
const dotenvExpand = require('dotenv-expand');
const BrowserSyncPlugin = require('browser-sync-v3-webpack-plugin');

// args
let options = yargs(process.argv.slice(2))
  .option('o', { alias: 'open-browser', type: 'boolean', default: false })
  .option('n', { alias: 'notify', type: 'boolean', default: false });

const argv = options.argv;

// env
dotenvExpand.expand(
  dotenv.config({
    path: '../.env',
  })
);

const env = process.env;

// config
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
  .webpackConfig({
    plugins: [
      new BrowserSyncPlugin(
        {
          proxy: {
            target: env.SERVER_NAME,
            // ws: true,
          },
          host: env.HOST_IP_LOCAL ?? undefined,
          port: env.BROWSERSYNC_PORT ?? undefined,
          open: argv.openBrowser,
          notify: argv.notify,
          ghostMode: false,
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
        },
        {
          reload: false,
        }
      ),
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
  .sass('src/scss/scope.scss', 'dist/css/leonidas.css', {
    sassOptions: {
      outputStyle: 'expanded',
      implementation: sass,
      quietDeps: true,
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
  // choices
  .copy(
    [
      './node_modules/choices.js/public/assets/scripts/choices.min.js',
      './node_modules/choices.js/public/assets/styles/choices.min.css',
    ],
    'dist/lib/choices/'
  )
  // select2
  .copy(
    [
      './node_modules/select2/dist/css/select2.min.css',
      './node_modules/select2/dist/js/select2.full.min.js',
    ],
    'dist/lib/select2/'
  )
  // trix
  .copy(
    [
      './node_modules/trix/dist/trix.esm.min.js',
      './node_modules/trix/dist/trix.css',
    ],
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
    purifyCss: false,
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
      loggingDebug: ['sass-loader'],
    },
  });
