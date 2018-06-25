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
<title>申请提现-<?php echo META_TITLE; ?></title>
<meta name="keywords" content="<?php echo META_TITLE; ?>">
<meta name="description" content="<?php echo META_TITLE; ?>">
<link type="text/css" rel="stylesheet" href="<?php echo $S_ROOT ?>images/style.css">
</head>
<body>
<div class="header">
	<div class="fl"><a href="<?php echo $S_ROOT ?>"><i class="gbicon gbicon-ac-arrowl-on"></i></a></div>
	<div class="title">申请提现</div>
</div>
<div class="reg">
    <div class="form-hd">* 提示：申请提现需要企业审核，一般3~7个工作日请悉知。</div>
	<form action="<?php echo $S_ROOT ?>user/confirmmoney" method="post" name="subform" id="subform">
	<input type="hidden" name="minprice" id="minprice" value="<?php echo $price; ?>">
	<div class="form">
		<div class="item"><label>银行账号</label><div class="text"><?php echo $bank_name; ?>(<?php echo $bank_last4; ?>)</div></div>
		<div class="item"><label>提现金额</label><input type="text" name="price" id="price" placeholder="0.00"></div>
		<div class="itemdesc clear" style="padding:10px">账户可用余额：<?php echo $price; ?>元 <span class="fr">冻结押金：<?php echo $deposit; ?>元</span></div>
		<div class="butn butnblue" id="subbutn" onclick="checkcharged()">申请提现</div>
	</div>
    </form>
</div>
<div class="copy">&copy;亿家净水提供技术支持</div>
<script type="text/javascript" src="<?php echo $S_ROOT ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $S_ROOT ?>js/plugin.js"></script>
<script type="text/javascript" src="<?php echo $S_ROOT ?>js/checkform.js?<?php echo time() ?>"></script>
</body>
</html>
