<?php
/**
+------------------------------------------------------------------------------
 * Spring Framework 架构配置
+------------------------------------------------------------------------------
 * @date        2011-01-17
 * @QQ        28683
 * @Author    Jeffy (darqiu@gmail.com)
 * @version    2.0
+------------------------------------------------------------------------------
 */

//载入工厂资源
require_once MVC . "action.php";
require_once MVC . "modules.php";
require_once LIB . "plugin.php";

//工厂设置实始化
$allfunc = array();

//数据库库名
if (!defined("DB_ORDERS")) {
    define('DB_ORDERS', "yws"); //DB_SALES
}
define('DB_PRODUCT', "product"); //DB_YIJIA
define('DB_MEMBERS', "members"); //DB_YIJIA
define('DB_CONFIG', "configure"); //DB_CONFIG
define('DB_OPEN', "openinfo"); //DB_CONFIG
define('DB_LOGS', "logs"); //DB_LOGS
define('DB_FUWU', "fuwu");
define('DB_WALLET', "wallet");
define('DB_B2B', "btob");
define('DB_YOS', "yos");
define('DB_KEEPER', "keeper");
define('DB_CLOUD', "cloud");
define('DB_YIJIA', "yijia");

//不受限制的门店
$sales = '0';
if (date("Y-m-d") <= "2013-03-25") {
    $sales = '19';
}
define('SALES_NULL', $sales); //DB_LOGS

//COOKIE前缀
if (!defined("COOKIE_PRE")) {define('COOKIE_PRE', 'yws2013');}

$hostname = $_SERVER["HTTP_HOST"];
if ($hostname == "adm.shui.cn") {
    // define('ALIOSS_URL'    ,"oss-cn-beijing-internal.aliyuncs.com");
    define('ALIOSS_URL', "vpc100-oss-cn-beijing.aliyuncs.com");
} else {
    define('ALIOSS_URL', "oss-cn-beijing.aliyuncs.com");
} // 外网 oss-cn-beijing.aliyuncs.com 内网 oss-cn-beijing-internal.aliyuncs.com

//DATABASE
$db             = getFunc("dbpdo");
$db->dbType     = 'mysql';
$db->connectNum = 'yws';
$db->configFile = CONFIG . "ydb.php"; //亿家网站 数据库配置
$allfunc["db"]  = $db;

//MSGBOX
$msg            = getFunc("message");
$msg->msgFile   = LIB . 'pages/msg.htm';
$allfunc["msg"] = $msg;

//COOKIE
$cookie            = getFunc("cookie");
$cookie->cookiePre = COOKIE_PRE;
//$cookie->secure = getFunc("secure");
$allfunc["cookie"] = $cookie;

//VIEWS
$tpl            = getFunc("view");
$tpl->tplDir    = VIEW;
$tpl->msg       = $msg;
$allfunc["tpl"] = $tpl;
include "wapfun.php";
function xdb()
{
    $xdb             = getFunc("dbpdo");
    $xdb->dbType     = 'mysql';
    $xdb->connectNum = 'xdb';
    $xdb->configFile = CONFIG . "xdb.php"; //数据库配置
    return $xdb;
}

function appError()
{
    echo "页面不存在";
    exit;
}

function msgbox($urlto = "", $msgbox = "", $timeout = 6000)
{
    global $tpl;
    $tpl->set("timeout", $timeout);
    $tpl->set("urlto", $urlto);
    $tpl->set("msgbox", $msgbox);
    if (wapfun::checked()) {
        $tpl->display("wap/msgbox.php");
    } else {
        $tpl->display("msgbox.php");
    }
    exit;
}

function jsmsg($script = "", $msgbox = "", $timeout = 3000)
{
    global $tpl;
    $tpl->set("timeout", $timeout);
    $tpl->set("script", $script);
    $tpl->set("msgbox", $msgbox);
    $tpl->display("msgbox.script.php");
    exit;
}

function dialog($msgbox = "")
{
    global $tpl;
    $tpl->set("msgbox", $msgbox);
    if (wapfun::checked()) {
        $tpl->display("wap/msgbox.dialog.php");
    } else {
        $tpl->display("msgbox.dialog.php");
    }
    exit;
}

function toplink($urlto = "")
{
    if ($urlto == "") {$urlto = S_ROOT;}
    header("location:$urlto");
    exit;
}

function apimsg($arr = "", $http = "404")
{
    $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
    header($protocol . " " . $http);
    echo json_encode($arr);
    exit;
}

function rejson($code = "200", $data = "", $msg = "")
{
    $arr            = array();
    $code           = ($code) ? $code : "200";
    $arr["code"]    = $code;
    $arr["data"]    = $data;
    $arr["message"] = $msg;
    $protocol       = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
    header($protocol . " 200");
    header("Content-type: application/json");
    echo json_encode($arr); //JSON_UNESCAPED_UNICODE
    exit;
}
