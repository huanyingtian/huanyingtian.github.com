module.exports = function(grunt){
	//引入模块
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-clean');
	//初始化任务
	grunt.initConfig({
		uglify:{
			ya1:{
				src:'tmp/index.js',
				dest:'dest/index.min.js'
			}
		},
		concat:{
			con1:{
				src:'src/*.js',
				dest:'tmp/index.js'
			}
		},
		clean:{
			clean1:'tmp'
		}
	});
	//注册默认任务
	grunt.registerTask('default',['concat','uglify','clean']);
};







