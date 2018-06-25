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
<title>订单详情-<?php echo META_TITLE; ?></title>
<meta name="keywords" content="<?php echo META_TITLE; ?>">
<meta name="description" content="<?php echo META_TITLE; ?>">
<link type="text/css" rel="stylesheet" href="<?php echo $S_ROOT ?>images/style.css?<?php echo time(); ?>">
</head>
<body>
<div class="header">
	<div class="fl"><a href="<?php echo $S_ROOT;?>user/orderslist"><i class="gbicon gbicon-ac-arrowl-on"></i></a></div>
	<div class="title">订单详情</div>
</div>
<form action="" method="post" name="subform" id="subform" class="normal">
	<div class="form">
		<div class="item itemhead"><label><?php echo $info['name']; ?></label><div class="text textleft"><?php echo substr_replace($info['mobile'],'****',3,4); ?></div></div>
		<div class="itemdesc"><?php echo $info['address']; ?></div>
		<div class="item clear"><label>配送方式</label> <div class="text textleft"><?php echo $delivertype[$info['delivertype']]['name']; ?> <a href="<?php echo $S_ROOT;?>product/modified?id=<?php echo base64_encode($info['id']); ?>" class="fr cblue">修改</a></div></div>
	</div>
	<div class="form">
		<div class="item"><label>商品名称</label><div class="text textleft"><?php echo $info['title']; ?></div></div>
		<div class="item"><label>商品单价</label><div class="text textleft"><?php echo $info['price']; ?>元</div></div>
		<div class="item"><label>合计金额</label><div class="text textleft cred"><?php echo $info['allprice']; ?>元</div></div>
	</div>
	<div class="form">
		<div class="item"><label>订单状态</label> <div class="text textleft"><?php echo $statustype[$info['status']]['name']; ?></div></div>
		<div class="item"><label>订单编号</label> <div class="text textleft"><?php echo $info['id']; ?></div></div>
		<div class="item"><label>下单日期</label> <div class="text textleft"><?php echo date('Y-m-d H:i',$info['dateline']); ?></div></div>

		<?php if($info['paystate'] != 1): 
			if ($_SERVER['HTTP_HOST'] == "test.shui.cn") {
                $urlto = "https://test.shui.cn/pay/weixin/orders?id=" . $info['id'];
            } else {
                $urlto = "https://pay.shui.cn/weixin/orders?id=" . $info['id'];
            }
		?>
		<div class="butn butnblue" id="subbutn"><a style="color: white;" href="<?php echo $urlto ?>">去支付</a></div>
		<?php endif; ?>
    </div>
</form>

<script type="text/javascript" src="<?php echo $S_ROOT ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $S_ROOT ?>js/checkform.js"></script>
<div class="copy">&copy;亿家净水提供技术支持</div>
</body>
</html>
