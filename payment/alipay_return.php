<?php
//************************ 系统函数设置 开始 ************************
//$beginTime = array_sum(split(' ', microtime()));
//开启页面缓冲
ob_start('ob_gzhandler');				//开启页面缓冲
error_reporting( E_ERROR | E_WARNING | E_PARSE );//屏蔽错误提示
header('Content-Type:text/html;charset=utf-8');//网页编码避免输出乱码
date_default_timezone_set('Asia/Shanghai');
ini_set('session.gc_probability',5);
ini_set('session.gc_divisor',100);
ini_set('session.gc_maxlifetime',10800);
//************************ 系统函数设置 结束 ************************
define('DEBUG',true);					//是否启用DEBUG
define('S_ROOT',str_replace(strtolower(trim(substr(strrchr($_SERVER["PHP_SELF"], '/'),1))),"",$_SERVER["PHP_SELF"]));
define('CONFIG', '../config/');			//配置文件路径
define('LIB', '../lib/');				//组件路径
define('CACHE','../cache/');				//缓存路径
define('IS_REWRITE',false);				//是否使用Rewrite重写
define('UPFILE',S_ROOT.'data/');		//上传路径
define('MVC','./app/');					//MVC根路径
define('ACTION',MVC.'action/');			//控制器目录
define('VIEW',MVC.'view/');				//视图文件目录
define('MODEL',MVC.'modules/');			//模型文件目录
define('META_TITLE',"YWS2.0 - Powered by Yijiawater");
define('META_KEY',"");
define('META_DESC',"201205v2");
define('META_AUTHOR',"亿家净水,qiuyong@1j.cn");
define('S_KEYWORDS',"");		//搜索框默认关键字
require_once(LIB."control.php");		//工厂组件
require_once(LIB."https.php");
$mod = "alipay";
$ac  = "alipay_return";
$tpl->set("S_ROOT",S_ROOT);
$reqac = getAction($mod);
$reqac->$ac();
ob_flush();	//输入页面缓存
//echo '<div align=center>Process: '.number_format((array_sum(split(' ', microtime())) - $beginTime), 6).'s</div>';
?>