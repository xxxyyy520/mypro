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
<title><?php echo META_TITLE; ?></title>
<meta name="keywords" content="<?php echo META_TITLE; ?>">
<meta name="description" content="<?php echo META_TITLE; ?>">
<script type="text/javascript">var S_ROOT = "<?php echo $S_ROOT;?>";</script>
<link type="text/css" rel="stylesheet" href="<?php echo $S_ROOT;?>images/style.css?<?php echo time() ?>">
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/checkform.js?<?php echo time() ?>"></script>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/jquery.js"></script>
</head>
<body class="fixed-botm">
<div class="home-top home-top<?php echo $level; ?>">
    <div class="top-out"></div>
    <div class="top-inner">
        <div class="top-info">
        	<div class="parent"><?php if($name) echo $name.'推荐'; ?></div>
            <div class="thumb"><a href="<?php echo $S_ROOT;?>user/ucenter"><img src="<?php echo $faceurl;?>" onerror="this.scr='<?php echo $S_ROOT;?>images/avatar/no-avatar.jpg'" class="authpic"></a></div>
            <div class="desc">-<?php echo $agencylevel; ?>-</div>
        </div>
        <ul class="top-account clear">
            <li><span><?php echo $wallet; ?></span><br><small>余额(元)</small></li>
            <li><span><?php echo $all_get_money; ?></span><br><small>总收益(元)</small></li>
            <li><span><?php echo $today_get_money; ?></span><br><small>今日收益(元)</small></li>
        </ul>
    </div>
</div>
<ul class="home-nav clear">
	<li><a href="<?php echo $S_ROOT;?>user/reg"><i class="iconsm iconsm-nlevel"></i><br>等级申请</a></li>
	<li><a onclick="charge('<?php echo md5('charge2018'); ?>')"><i class="iconsm iconsm-ncharge"></i><br>申请提现</a></li>
	<li><a href="<?php echo $S_ROOT;?>user/fans"><i class="iconsm iconsm-nfans"></i><br>粉丝</a></li>
	<li><a href="<?php echo $S_ROOT;?>user/ordersplist"><i class="iconsm iconsm-norders"></i><br>下单</a></li>
</ul>


<div class="home-items">
	<div class="mh">销售中心</div>
	<ul class="home-nav clear">
		<li><a href="<?php echo $S_ROOT;?>product/poster"><i class="iconsm iconsm-nposter"></i><br>产品海报</a></li>
		<li><a href="<?php echo $S_ROOT;?>product/qrcode"><i class="iconsm iconsm-nqrcode"></i><br>专属海报</a></li>
		<li><a href="<?php echo $S_ROOT;?>product/sales"><i class="iconsm iconsm-nsales"></i><br>全部销售<!-- <span class="cgray">总销售23台</span> --></a></li>
		<li><a href="<?php echo $S_ROOT;?>user/wallet"><i class="iconsm iconsm-nwallet"></i><br>收入明细</a></li>
	</ul>
</div>
<div class="home-items">
	<div class="mh">服务中心</div>
	<ul class="home-nav clear">
		<li><a href="<?php echo $S_ROOT;?>user/orderslist"><i class="iconsm iconsm-nmine"></i><br>订单中心</a></li>
		<li><a href="<?php echo $S_ROOT;?>user/salestop"><i class="iconsm iconsm-ntop"></i><br>排行榜</a></li>
		<li><a href="<?php echo $S_ROOT;?>product/fapiao"><i class="iconsm iconsm-nfapiao"></i><br>发票信息</a></li>
	</ul>
</div>
<div class="fixed home-butn"><a href="<?php echo $S_ROOT;?>article" class="cblue">分享小技巧</a></div>
<div class="copy">&copy;亿家净水提供技术支持</div>
</body>
</html>
