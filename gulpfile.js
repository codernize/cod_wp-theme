// Include gulp
var gulp = require('gulp');

// Include Our Plugins
var jshint = require('gulp-jshint');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var sourcemaps = require('gulp-sourcemaps');

var path = require("path");

const SASS_INCLUDE_PATHS = [
    path.join(__dirname, '/node_modules/foundation-sites/_vendor/normalize-scss/sass'),
    path.join(__dirname, '/node_modules/foundation-sites/scss')

];

// Lint Task
gulp.task('lint', function() {
    return gulp.src('js/*.js')
        .pipe(jshint())
        .pipe(jshint.reporter('default'));
});

// Compile Our Sass
gulp.task('sass', function() {
    return gulp.src('scss/*.scss')
        // .pipe(sourcemaps.init())
        .pipe(sass(
            {
                outputStyle: 'compressed',
                includePaths: SASS_INCLUDE_PATHS
            }
            ))
        // .pipe(sourcemaps.write())
        .pipe(gulp.dest('css'));
});

// Concatenate & Minify JS
gulp.task('scripts', function() {
    return gulp.src('js/*.js')
        .pipe(concat('all.js'))
        .pipe(gulp.dest('js/dist'))
        .pipe(rename('all.min.js'))
        .pipe(uglify({ mangle: false }))
        .on('error', function (err) { console.log( err ) })
        .pipe(gulp.dest('js/dist'));
});

// Watch Files For Changes
gulp.task('watch', function() {
    gulp.watch('js/*.js', [/*'lint',*/ 'scripts']);
    gulp.watch('scss/*.scss', ['sass']);
});

// Default Task
gulp.task('default', [ 'sass', 'scripts', 'watch']);