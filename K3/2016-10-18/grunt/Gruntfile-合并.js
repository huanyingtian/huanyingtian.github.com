module.exports = function(grunt){
	//引入模块
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-concat');
	//初始化任务
	grunt.initConfig({
		uglify:{
			ya1:{
				src:'src/a.js',
				dest:'dest/a.min.js'
			},
			ya2:{
				src:'src/b.js',
				dest:'dest/b.min.js'
			}
		},
		concat:{
			con1:{
				src:'src/*.js',
				dest:'dest/index.js'
			}
		}
	});
	//注册默认任务
	grunt.registerTask('default',['concat']);
};







