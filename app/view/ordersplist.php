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
<title>下单商城-<?php echo META_TITLE; ?></title>
<meta name="keywords" content="<?php echo META_TITLE; ?>">
<meta name="description" content="<?php echo META_TITLE; ?>">
<link type="text/css" rel="stylesheet" href="<?php echo $S_ROOT;?>images/style.css?<?php echo time() ?>">
</head>
<body>
<div class="header">
	<div class="fl"><a href="<?php echo $S_ROOT;?>"><i class="gbicon gbicon-ac-arrowl-on"></i></a></div>
	<div class="title">下单商城</div>
</div>

<!-- <div class="pitem">
   <div class="thumb">
   	   <img src="https://alifuwu.shui.cn/images/weapps/x1.jpg" alt="HIOUS 台上式速热净饮机（X1）">
	   <div class="mark">
           <a href="<?php echo $S_ROOT;?>user/orders?num=1&encoded=008864">1件</a>
           <a href="<?php echo $S_ROOT;?>user/orders?num=5&encoded=008864">&gt;5件</a>
	   </div>
   </div>
   <div class="title">HIOUS 台上式速热净饮机（X1） <span class="fr cblue">租金 2元/天</span></div>
</div> -->

<?php foreach ($lists as $value): ?>
<div class="pitem">
   <a href="<?php echo $S_ROOT;?>user/orders?encoded=<?php echo $value['encoded'] ?>">
	   <div class="thumb"><img src="<?php echo $value['img'] ?>" alt="<?php echo $value['title'] ?>"></div>
	   <div class="title"><?php echo $value['title'] ?><span class="fr cblue"><?php echo $value['priceinfo']; ?></span></div>
   </a>
</div>
<?php endforeach; ?>


<div class="copy">&copy;亿家净水提供技术支持</div>
</body>
</html>
