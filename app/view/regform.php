<!DOCTYPE html>
<html lang="ZH-CN">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="author" content="d.shui.cn">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=yes">
<meta http-equiv="Expires" content="-1">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Pragma" content="no-cache">
<title>等级申请-<?php echo META_TITLE; ?></title>
<meta name="keywords" content="<?php echo META_TITLE; ?>">
<meta name="description" content="<?php echo META_TITLE; ?>">
<link type="text/css" rel="stylesheet" href="<?php echo $S_ROOT;?>images/style.css?<?php echo time(); ?>">
</head>
<body>
<div class="header">
	<div class="fl"><a href="<?php echo $S_ROOT;?>user/reg"><i class="gbicon gbicon-ac-arrowl-on"></i></a></div>
	<div class="title">等级申请</div>
</div>
<div class="reg">
     <div class="form-hd">如果您希望成为我们的城市合伙人，请简单登记您目前的团队和经营情况，我们会尽快于您联系。</div>
	<form action="" method="post" name="subform" id="subform">
	<div class="form">
          <div class="item"><label>姓名</label><input type="text" name="name" id="name" placeholder="您的真实姓名"></div>
          <div class="item"><label>联系方式</label><input type="text" name="mobile" id="mobile" placeholder="您的有效联系方式"></div>
          <div class="item"><label>所属区域</label>
               <select name="provid" id="provid" style="width:30%;"></select>
               <select name="cityid" id="cityid" style="width:30%;"></select>
               <select name="areaid" id="areaid" style="width:30%;"></select>
          </div>
          <div class="item"><label>详细地址</label><textarea name="address" id="address" placeholder="详细到门牌号"></textarea></div>
          <div class="butn" id="subbutn" onclick="checkreg()">保存申请</div>
	</div>
    </form>
</div>

<div class="copy">&copy;亿家净水提供技术支持</div>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/plugin.js"></script>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/provincetip.js"></script>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/checkform.js?<?php echo time(); ?>"></script>
</body>
</html>
