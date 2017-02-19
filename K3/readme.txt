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
    
      