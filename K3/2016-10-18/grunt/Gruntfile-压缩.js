module.exports = function(grunt){
	//引入模块
	grunt.loadNpmTasks('grunt-contrib-uglify');
	//初始化任务
	grunt.initConfig({
		uglify:{
			ya1:{
				src:'src/a.js',
				dest:'dest/a.min.js'
			}
		}
	});
	//注册默认任务
};