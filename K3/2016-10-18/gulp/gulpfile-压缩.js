var gulp = require('gulp'),
	uglify = require('gulp-uglify');

gulp.task('uglify',function(){
	gulp.src('src/a.js')
		.pipe(uglify())
		.pipe(gulp.dest('dest'));
});
