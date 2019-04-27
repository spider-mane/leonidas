// Load Gulp
const gulp = require('gulp');

// CSS plugins
const sass = require('gulp-sass');
// const autoprefixer = require('gulp-autoprefixer');
// const minifycss = require('gulp-uglifycss');

// JS plugins
const babelify = require('babelify');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');
const buffer = require('vinyl-buffer');
const browserify = require('browserify');
const webpack = require("webpack-stream");
const source = require('vinyl-source-stream');
const stripDebug = require('gulp-strip-debug');

// Utility plugins
const gulpif = require('gulp-if');
const notify = require('gulp-notify');
const rename = require('gulp-rename');
const options = require('gulp-options');
const plumber = require('gulp-plumber');
const sourcemaps = require('gulp-sourcemaps');

// Brower plugins
const browserSync = require('browser-sync').create();

// Secondary Requirements
const reload = browserSync.reload;
sass.compiler = require("node-sass");

// ############################## Directories and Files ##############################
//
const projectURL = 'http://localhost/backalley/wp-admin';
const browser = "C:\\Program Files (x86)\\Google\\Chrome Dev\\Application\\chrome.exe";

// CSS/ SCSS
const styleSrcDir = './src/scss/'
const styleSrcMain = 'bawl-main.scss';
const styleSrcTermSort = 'word-less-sort-objects.scss';
const styleSrcFiles = [styleSrcMain, styleSrcTermSort];

const styleDistDir = './assets/css/';
const styleDistFile = 'styles.css';

// JS
const jsSrcDir = './src/js/';
const jsSrcFile = 'index.js';

const jsDistDir = './assets/js/';
const jsDistFile = 'word-less-script.js';

// Watch Locations
const phpWatch = '**/*.php';
const twigWatch = './templates/**/*.twig';
const scssWatch = `${styleSrcDir}**/*.scss`;
const jsSrcWatch = `${jsSrcDir}**/*.js`;
const cssWatch = `${styleDistDir}**/*.css`;
const jsWatch = `${jsDistDir}**/*.js`;

// ############################## Task Definitions ##############################

gulp.task('default', defaultTask);
gulp.task('serve', launchProxy);
gulp.task('sass', compileSass);
gulp.task('pack', compileJS);
// gulp.task('babel', babelifyJS);
gulp.task('compile', compileAll);

// ############################## Task Functions ##############################

function defaultTask() {
    this.flags = {
        "--max-old-space-size=4076": "Increase maximum allowed memory"
    };

    compileSass();
    compileJS();
    // launchProxy();

    // compile shits
    gulp.watch(scssWatch, compileSass);
    gulp.watch(jsSrcWatch, compileJS);

    // // reload browser
    // gulp.watch(phpWatch).on("change", reload);
    // gulp.watch(twigWatch).on("change", reload);
    // gulp.watch(cssWatch).on("change", reload);
    // gulp.watch(jsWatch).on("change", reload);
}

function compileAll(done) {
    compileJS();
    compileSass();
    done();
}

function launchProxy() {
    browserSync.init({
        proxy: projectURL,
        notify: false,
        reloadOnRestart: true,
        open: false,
        browser: browser
    });
}

function compileSass() {
    var options = {
        outputStyle: 'expanded',
    };

    return gulp.src(styleSrcFiles.map(file => styleSrcDir + file))
        .pipe(plumber())
        .pipe(sass(options).on('error', sass.logError))
        .pipe(gulp.dest(styleDistDir))
        .pipe(browserSync.stream());
}

function compileJS() {
    let jsNoCache = jsDistFile.split('.');
    jsNoCache.splice(1, 0, '[contenthash]');
    jsNoCache.join('.');

    const config = {
        output: {
            filename: jsDistFile
        },
        mode: 'development',
        module: {
            rules: [{
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader'
                }
            }]
        }
    };

    return gulp.src(jsSrcDir + jsSrcFile)
        .pipe(plumber())
        .pipe(webpack(config))
        .pipe(gulp.dest(jsDistDir))
        .pipe(browserSync.stream());
}