<?php
/**
+------------------------------------------------------------------------------
* Spring Framework 工厂模式
+------------------------------------------------------------------------------
* @date		2011-01-17
* @QQ		28683
* @Author	Jeffy (darqiu@gmail.com)
* @version	2.0
+------------------------------------------------------------------------------
*/
//处理GET请求规则
if(IS_REWRITE)
{
	$strvar = "-"; //字符串间隙
	$fullUrl  = $_SERVER['REQUEST_URI'];
	$filename = $_SERVER['SCRIPT_NAME'];
	$getArgs  = $_SERVER['QUERY_STRING'];
	if(S_ROOT=='/'){ $S_ROOT = ''; }else{ $S_ROOT = S_ROOT; }
	$searchStr = array($S_ROOT,$filename,'?'.$getArgs,'.html','.js');//,'index.php'
	$url = str_replace($searchStr,'',$fullUrl);
	$url = trim($url,"/");
	$urlarr = explode('/',$url);
	if($urlarr[0]=="index.php"){ header("location:/"); }
	$arrNum = count($urlarr);
	switch($arrNum){
		case "1" : 
			$_GET["mod"]  = $urlarr[0];
			break;
		case "2" :
			$_GET["mod"]  = $urlarr[0];
			$_GET["ac"]   = $urlarr[1];
			break;
		default :
			$_GET["mod"]  = $urlarr[0];
			$_GET["ac"]   = $urlarr[1];
			if($arrNum>2){
				for($i=0;$i<$arrNum-2;$i++){
					if($i>0){ $do = $i; };
					$_GET["do".$do] = $urlarr[$i+2];
				}
			}
	}
	$_GET["mod"] = (isset($_GET["mod"])&&!empty($_GET["mod"]))?$_GET["mod"]:"index";
	//print_r($_GET);
}
//print_r($_GET);

//加载工厂配置
require_once(LIB."app.php");

//组件加载工厂
Function getFunc($object)
{
	GLOBAL $msg;
	$objectfile = LIB.$object.".php";
	if(file_exists($objectfile)){
		require_once($objectfile);
		if(!class_exists($object)){
			if(DEBUG){
				$msg->show("组件 $object 对象未找到!");
			}else{
				appError();
			}
		}
		return new $object();
	}else{
		if(DEBUG){
			$msg->show("ERROR：组件 $object 不存在！");
		}else{
			appError();
		}
	}
}

//加载视图
Function getAction($action)
{
	GLOBAL $allfunc,$msg;
	if(!isset($action)){ $action="index"; }
	//加载视图
	$mod = ACTION.$action.".php";
	if(!file_exists($mod)){
		//$mod = ACTION."index.php";
		if(DEBUG){
			$msg->show("错误，页面不存在！");
		}else{
			appError();
		}
	}
	require_once($mod);
	$classname = $action.'Action';
	if(!class_exists($classname)){
		//$classname = 'indexAction';
		if(DEBUG){
			$msg->show("控制器 $action 对象未找到!");
		}else{
			appError();
		}
	}
	$mp = new $classname();
	foreach($allfunc AS $id=>$fun){
		$mp->$id = $fun;
	}
	return $mp;
}

//加载模块
Function getModel($model)
{
	GLOBAL $allfunc,$msg;
	//加载model,写入属性
	$mod = MODEL.$model.".php";
	if(!file_exists($mod)){
		if(DEBUG){
			$msg->show("模块[$model]不存在");
			//$msg->show("你所访问的页面不存在！<!-- <br>ERROR：模块[$model]不存在 -->");else{
			//msgBox
		}else{
			appError();
		}
	}
	require_once($mod);
	$classname = $model.'Modules';
	if(!class_exists($classname)){
		if(DEBUG){
			$msg->show("模块 $classname 对象未找到!");
		}else{
			appError();
		}
	}
	$mp = new $classname();
	foreach($allfunc AS $id=>$fun){
		$mp->$id = $fun;
	}
	return $mp;
}

?>