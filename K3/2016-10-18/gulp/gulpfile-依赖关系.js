var gulp = require('gulp'),
	uglify = require('gulp-uglify'),
	rename = require('gulp-rename'),
	concat = require('gulp-concat');

gulp.task('uglify',['concat'],function(){
	return gulp.src('tmp/index.js')
		.pipe(uglify())
		.pipe(rename('index.min.js'))
		.pipe(gulp.dest('dest'));
});
gulp.task('concat',function(){
	return gulp.src('src/*.js')
		.pipe(concat('index.js'))
		.pipe(gulp.dest('tmp'));
});

gulp.task('default',['concat','uglify']);














