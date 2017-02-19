var gulp = require('gulp'),
	uglify = require('gulp-uglify'),
	rename = require('gulp-rename'),
	concat = require('gulp-concat');

gulp.task('uglify',function(){
	gulp.src('src/a.js')
		.pipe(uglify())
		.pipe(rename('a.min.js'))
		.pipe(gulp.dest('dest'));
});
gulp.task('concat',function(){
	gulp.src('src/*.js')
		.pipe(concat('index.js'))
		.pipe(gulp.dest('dest'));
});

gulp.task('default',['concat']);














