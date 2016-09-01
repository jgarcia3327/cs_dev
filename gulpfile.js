var gulp = require('gulp');
var livereload = require('gulp-livereload')
var uglify = require('gulp-uglifyjs');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var sourcemaps = require('gulp-sourcemaps');

var connect= require('gulp-connect');
var browserify = require('browserify');
var babelify = require('babelify');
var source = require('vinyl-source-stream');
/*
gulp.task('connect', function(){
    connect.server({
        base: 'http://localhost',
        port: 9000,
        root: './',
        livereload: true
    });
});*/

/*
gulp.task('babelify', function(){
    browserify('./src/js/react/main.js')
        .transform(babelify)
        .bundle()
        .pipe(source('mainReact.js'))
        .pipe(gulp.dest('./js'))
        .pipe(connect.reload());
});*/

/*
gulp.task('html', function(){
    gulp.src('./src/*.html')
        .pipe(gulp.dest('./'))
        .pipe(connect.reload());
});*/

gulp.task('subHtml', function(){
    gulp.src('./src/html/*.html')
        .pipe(gulp.dest('./html/'))
        .pipe(connect.reload());
});

gulp.task('sass', function () {
  gulp.src('./src/sass/**/*.scss')
    .pipe(sourcemaps.init())
        .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
        .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 7', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest('./css'))
    .pipe(connect.reload());
});

gulp.task('uglify', function() {
  gulp.src('./src/js/main/*.js')
    .pipe(uglify('main.js'))
    .pipe(gulp.dest('./js'))
    .pipe(connect.reload());
});

gulp.task('watch', function(){
    //gulp.watch('./src/js/react/*.js', ['babelify']);
    //gulp.watch('./src/*.html', ['html']);
    gulp.watch('./src/html/*.html', ['subHtml']);
    gulp.watch('./src/sass/**/*.scss', ['sass']);
    gulp.watch('./src/js/main/*.js', ['uglify']);
});

gulp.task('default', [/*'connect',*/ /*'babelify',*/ /*'html',*/ 'subHtml', 'sass', 'uglify', 'watch'], function(){

});
