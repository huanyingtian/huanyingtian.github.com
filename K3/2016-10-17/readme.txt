笔记
================================================
代码管理工具
集中式代码管理工具
	1.只能在公司用
	2.相对简单
SVN
	官网:https://tortoisesvn.net/
 	安装:无限下一步，重启电脑
 	验证是否安装成功
 		鼠标右键:有svn的图标
================================================
	需要有一个svn的服务器。
	SinaApp
	官网:http://sinaapp.com/

	以上服务器在公司不需要你负责。有能用的。让你用。


	把服务器上的代码下载下来
		鼠标右键 	checkout

	保证代码最新
		update

	上传
		update
		commit
============================================
分布式代码管理工具
	1.在哪都能用
	2.比较难
Git
	官网:http://msysgit.github.io/
	安装:无限下一步
	如何验证是否安装成功
		右键有git
	玩git有两种方式
		1.Git GUI 	 	图形界面
		2.Git Bash 		命令行 			√

	打开git bash
		输入
		git --version 		检测git的版本

GitHub 			git服务器
	管理我们的代码

网址:https://github.com/
	提前准备
		两个邮箱
			一个新浪邮箱
			一个QQ邮箱


	注册
		用户名 	必须英文字母开头
		邮箱 	填写sina邮箱
		密码 	英文+数字

		点击 Sign up for Github

	配置邮箱
		点击-》头像-》点击-》settings
			点击emails
			登录sina邮箱
				打开github发送的邮件
				点击里面的连接
			跳转到新的github页面
	从新添加另一个邮箱
		点击-》头像-》点击-》settings
			点击emails
			添加另一个邮箱
			点击add
				打开qq邮箱
				点击里面的连接
			跳转到新的github页面

	添加SSH Key 		秘钥
		生成一个秘钥
		打开命令行
			ssh-keygen -t rsa -C "主邮箱"
				一路回车
		需要找到生成的秘钥
			在用户目录下有一个.ssh文件夹
			id_rsa
			id_rsa.pub 		√
		**不能使用任何编辑器打开这个文件
			只能通过记事本打开此文件
			把里面的内容全选，复制
		点击头像-》点击settings-》
		点击-》SSH and GPG keys-》
		点击-》New SSH key
		输入两个东西
			title
				用户名
			key
				粘贴
		点击-》Add SSH key

	配置信息
		邮箱和用户名
		git config -l 		查看有哪些配置
		用户名
		git config --global user.name "用户名"(一定跟ssh key的名字保持一致)
		邮箱
		git config --global user.email "主邮箱"
====================================================
点击头像-》点击your profile
====================================================




=========================================
linux命令
	clear 					清屏
	exit 					退出
	cd 目标 				切换盘符目录
	ls 						查看文件夹内容
	cat 文件 				查看文件内容

	vi 文件 				文件操作
		阅读模式		默认

		按一下 		i    	
			进入编辑模式

		退出		按esc
			不保存退出
				:q! 			回车
			保存退出
				:wq! 			回车
===================================================
本地项目上传到github中
github上的已有项目下载到本地
创建个人网站

代码自动构建工具
Gulp
Grount









































