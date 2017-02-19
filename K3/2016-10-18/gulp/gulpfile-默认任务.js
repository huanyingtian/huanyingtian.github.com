var gulp = require('gulp'),
	uglify = require('gulp-uglify'),
	rename = require('gulp-rename');

gulp.task('uglify',function(){
	gulp.src('src/a.js')
		.pipe(uglify())
		.pipe(rename('a.min.js'))
		.pipe(gulp.dest('dest'));
});

gulp.task('default',['uglify']);

