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
<title>下单-<?php echo META_TITLE; ?></title>
<meta name="keywords" content="<?php echo META_TITLE; ?>">
<meta name="description" content="<?php echo META_TITLE; ?>">
<link type="text/css" rel="stylesheet" href="<?php echo $S_ROOT;?>images/style.css?<?php echo time() ?>">
</head>
<body>
<div class="header">
	<div class="fl"><a href="<?php echo $S_ROOT;?>user/ordersplist"><i class="gbicon gbicon-ac-arrowl-on"></i></a></div>
	<div class="title">下单</div>
</div>
<form action="<?php echo $S_ROOT;?>user/ordersmsg" method="post" name="subform" id="subform" class="normal">
<input type="hidden" name="priceone" id="priceone"  value="<?php echo $info['price_sales'] ?>">
<input type="hidden" name="title" id="title"  value="<?php echo $info['title'] ?>">
<input type="hidden" name="encoded" id="encoded"  value="<?php echo $info['encoded'] ?>">
<input type="hidden" name="productid" id="productid"  value="<?php echo $info['productid'] ?>">
<div class="form">
    <div class="item"><label>收货人</label><input type="text" name="name" id="name" placeholder="收货人姓名"></div>
    <div class="item"><label>联系方式</label><input type="text" name="mobile" id="mobile" placeholder="收货人的有效手机号"></div>
    <div class="item"><label>收货区域</label>
       <select name="provid" id="provid" style="width:30%;"></select>
       <select name="cityid" id="cityid" style="width:30%;"></select>
       <select name="areaid" id="areaid" style="width:30%;"></select>
    </div>
    <div class="item"><label>详细地址</label><textarea name="address" id="address" placeholder="详细到门牌号"></textarea></div>
    <div class="item"><label>配送方式</label>
		<span class="radioround"><input type="radio" name="type" value="4" checked="checked" onclick="chargetype()"> 第三方配送</span>
		<span class="radioround"><input type="radio" name="type" value="1" onclick="chargetype()"> 送货上门</span>
	</div>
</div>
<div class="form">
    <div class="item itemleft clear"><img src="<?php echo $S_ROOT;?>images/base/paywx.png" alt="微信支付" width="30" height="30">微信支付 <span class="fr"><input type="radio" name="paytype" id="paytype" value="weixin" checked="checked"></span></div>
    <!-- <div class="item itemleft clear"><img src="<?php echo $S_ROOT;?>images/base/payalipay.png" alt="支付宝支付" width="30" height="30">支付宝支付 <span class="fr"><input type="radio" name="paytype" id="paytype" value="alipay" ></span></div>
    <div class="item itemleft clear"><img src="<?php echo $S_ROOT;?>images/base/payyijia.png" alt="亿家余额" width="30" height="30">亿家余额 <span class="fr"><input type="radio" name="paytype" id="paytype" value="charge"></span></div> -->
</div>
<div class="form">
    <!-- <div class="item"><label>购买数量</label><div class="text">1台</div><input type="hidden" name="nums" id="nums" value="1"></div> -->
    <div class="item clear"><label>购买数量</label>
        <div class="tool-nums fr">
            <?php if($num == 5){ ?>
            <span class="toleft" onclick="changenums(1)">-</span>
            <input type="number" class="nums" name="nums" id="nums" min="5" placeholder="最低购买5台" value="5">
            <span class="toright" onclick="changenums(0)">+</span>
            <?php }else{ ?>
            <span name="nums" id="nums">1</span>
            <!-- <input type="number" class="nums" name="nums" id="nums" value="1"> -->
            <?php } ?>
        </div>
    </div>
	<div class="item"><label>商品名称</label><div class="text">HIOUS 台上式速热净饮机（X1）</div></div>
	<div class="item"><label>租赁类型</label><div class="text">1460元/2年</div></div>
	<div class="item"><label>商品单价</label><div class="text">1460元</div></div>
	<div class="item"><label>合计金额</label><div class="text cred"><span id="allprice"><?php echo $info['price_sales']; ?></span>元</div></div>
	<div class="butn butnblue" id="subbutn" onclick="checkorders()">去支付</div>
</div>
</form>

<div class="copy">&copy;亿家净水提供技术支持</div>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/provincetip.js"></script>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/plugin.js"></script>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/checkform.js?<?php echo time(); ?>"></script>
</body>
</html>
