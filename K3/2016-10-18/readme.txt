笔记
===============================================
git 			分布式代码管理工具
github
	配置流程
		验证邮箱
			主邮箱、次邮箱
		添加SSH key
			ssh-keygen -t rsa -C "主邮箱"
		配置
		git config -l 
				查看所有配置
		git config --global user.name ""
				配置用户名
		git config --global user.email ""
				配置邮箱
===============================================
管理项目
	本地创建了一个项目，需要上传到github中
		1).本地先创建一个空的项目
		2).在github中也创建一个一模一样的项目
			点击-》头像左边的加号"+"-》
			点击-》New repository
			填写项目名称需要跟本地的名称一致
			填写项目描述
			两个选项
				public 		公开的 		√
				private 	私有的
			点击-》Create repository
			推荐每个项目都有这三个文件
				README 			说明文档 		√
				LICENSE 		开源许可证
				.gitignore 		忽略 			√
			在本地项目中创建README文件
			需要在项目目录中执行以下代码
				git init
				git add README.txt
				git commit -m "first commit"
				git remote add origin https://github.com/itwenqiang/demo.git
				git push -u origin master
			提示输入用户名(***最好输入主邮箱)
			提示输入密码(***linux中输入密码看不到)


			上传
 				git add 文件
 				git commit -m "备注"
 				git push


 			git add . 			添加所有
 			git add --all 		删除文件的时候使用

			玩git hub 一定要 学会问
				git status


	github中已有的项目，下载到本地
		点击-》Clone or downloaded
		把链接复制下来

		git clone 链接


		开发之前拉取最新
			git pull

		工作流程
			git pull
			操作
			git add
			git commit -m "备注"
			git push


	创建个人站
		项目名必须:
		用户名.github.com

		点击 	settings
		点击 	Launch automatic page generator
		点击 	Continue to layouts
			选择你喜欢的模板
		点击 	Publish page
    
      
      .gitignore
      		忽略文件上传
====================================================
代码自动构建工具
Grount 			
	官网:http://gruntjs.com/
	基于nodejs
	检测node是否有
		node --version
		npm --version

	node就是js文件
	执行		node 文件
================================================
	1.需要安装grunt的命令行环境
		npm install -g grunt-cli
	2.检测是否安装成功
		grunt --version

	想玩grunt，必须有两个文件
		Gruntfile.js 		构建主文件
		package.json 		工程文件

	编写Gruntfile.js
	module.exports = function(grunt){
		//引入模块
		grunt.loadNpmTasks('模块名');
		//初始化任务
		grunt.initConfig({
			主任务:{
				子任务:{
					src:'',
					dest:''
				}
			}
		});
		//注册任务
		grunt.registerTask('default',[任务名]);
	};

	安装模块
		grunt 					模块
			npm install grunt
		grunt-contrib-uglify 	模块
			压缩模块
			npm install grunt-contrib-uglify
		grunt-contrib-clean 	模块
			删除模块
			npm install grunt-contrib-clean
===============================================
package.json
	npm init

	npm install 模块名 --save-dev

	npm install 		安装package.json里面记录的模块

=====================================================
	Grunt和Gulp的区别？
		Grunt 		走文件流 				慢
		Gulp 		走二进制管道 			快


Gulp
	官网:http://gulpjs.com/

	需要安装gulp的命令行环境
		npm install --global gulp-cli
	验证是否安装成功
		gulp --version

	必须有两个文件
		gulpfile.js
		package.json

	编写gulpfile
	//引入模块
	var gulp = require('gulp');

	gulp.task('任务名',function(){

	})

	gulp.task('default',['任务名'])


	安装模块
		npm install 模块名

		gulp
		npm install gulp
























