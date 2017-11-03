<?php
$style_config_dir = '../data/cache/';
$config_file = str_replace("\\", '/', realpath($style_config_dir)).'/style_config.php';
$config = require $config_file;
if(isset($_POST['style'])){
	$config['current_style'] = $_POST['style'];
}
if(isset($_POST['mobile_style'])){
	$config['mobile_style'] = $_POST['mobile_style'];
}

if(isset($_POST['contact_style'])){
	$file=fopen("../source/module/contact.php", "w+") or die('文件contact无法创建');
    $c = '<?php $contactid='.'"'.$_POST['contact_style'].'"; ?>';
	if(!fwrite($file,$c))
	{
		fclose($file);
		exit('注意参数无法写入配置文件！');
	}
	fclose($file); 
	exit();
}

if(!is_file($config_file)){
	touch($config_file);
}
if(file_put_contents($config_file, "<?php \nreturn ".var_export($config, true).';')){
	echo 1;
}else{
	echo 0;
}
exit();