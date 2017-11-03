<?php
require M_ROOT."model/model.php";
$tpl->assign('m_path', M_PATH);
$tpl->assign('m_tpl',M_TEMPLATE);
$tpl->assign('path_index',PATH_URL);
$tpl->assign('murl_index',PATH_URL.'m/');
$tpl->assign('murl_about',PATH_URL.'m/about/');
$tpl->assign('murl_product',PATH_URL.'m/product/');
$tpl->assign('murl_news',PATH_URL.'m/news/');
