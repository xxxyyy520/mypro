<?php
header('Content-Type: text/html; charset=UTF-8');
$config['QY_CORPID']      = 'WWf245d00976c8a28a'; //企业微信corpid
$config['QY_URLTOKEN']    = 'CLOKmEEsNUx49UiQN75jWIkf';//回调发送消息配置token
$config['QY_URLENKEY']    = 'QJd9GsJQleGGdx4tR9zdTCC1zCNuw3gH6tWXgf6FBss';//回调发送消息encodingAesKey
$config['QY_SECRET']      = 'sCMrDP-3gH8phd-d1Zi731QP1moDlCPADQzRgZNoTRQ';//企业微信通讯录应用secret
$config['QY_YOSSECRET']   = 'CSmB36vw7dl0CudpgdexsNzfezugipTINbkhhE02YcM';//企业微信YWS应用secret
$config['QY_REDIRECTURI'] = 'https://yws.shui.cn/api/qylogin';//企业微信网页授权回调地址
define('QY_CORPID',$config["QY_CORPID"]);
define('QY_URLTOKEN',$config["QY_URLTOKEN"]);
define('QY_URLENKEY',$config["QY_URLENKEY"]);
define('QY_SECRET',$config["QY_SECRET"]);
define('QY_YOSSECRET',$config["QY_YOSSECRET"]);
define('QY_YOSAGENTID',$config["QY_YOSAGENTID"]);
define('QY_REDIRECTURI',$config["QY_REDIRECTURI"]);
?>
