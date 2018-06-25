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
<title>排行榜-<?php echo META_TITLE; ?></title>
<meta name="keywords" content="<?php echo META_TITLE; ?>">
<meta name="description" content="<?php echo META_TITLE; ?>">
<link type="text/css" rel="stylesheet" href="<?php echo $S_ROOT;?>images/style.css">
</head>
<body>
<div class="header">
	<div class="fl"><a href="<?php echo $S_ROOT;?>"><i class="gbicon gbicon-ac-arrowl-on"></i></a></div>
	<div class="title">排行榜</div>
</div>
<div class="snav">
	<span <?php if($time == 'week') echo 'class="current"'; ?>><a href="<?php echo $S_ROOT ?>user/salestop?time=week">周榜</a></span>
	<span <?php if($time == 'month') echo 'class="current"'; ?>><a href="<?php echo $S_ROOT ?>user/salestop?time=month">月榜</a></span>
	<span <?php if($time == 'all') echo 'class="current"'; ?>><a href="<?php echo $S_ROOT ?>user/salestop?time=all">总榜</a></span>
</div>
<div class="sales-top">
   <div class="top-head clear">
	   <div class="item">
	       <i class="iconsm iconsm-top2"></i>
	       <div class="name"><?php echo $ranking[1]['name']; ?></div>
	       <div class="price"><?php echo $ranking[1]['allsales']; ?></div>
	   </div>
	   <div class="item">
	       <i class="iconsm iconsm-top1"></i>
	       <div class="name"><?php echo $ranking[0]['name']; ?></div>
	       <div class="price"><?php echo $ranking[0]['allsales']; ?></div>
	   </div>
	   <div class="item">
	       <i class="iconsm iconsm-top3"></i>
	       <div class="name"><?php echo $ranking[2]['name']; ?></div>
	       <div class="price"><?php echo $ranking[2]['allsales']; ?></div>
	   </div>
    </div>
	<table width="100%">
	  <tr>
	     <th>排名</th>
	     <th>粉丝</th>
	     <th>收益</th>
	  </tr>
	  <tr>
	     <td>4</td>
	     <td><?php echo $ranking[3]['name']; ?></td>
	     <td><?php echo $ranking[3]['allsales']; ?></td>
	  </tr>
	  <tr>
	     <td>5</td>
	     <td><?php echo $ranking[4]['name']; ?></td>
	     <td><?php echo $ranking[4]['allsales']; ?></td>
	  </tr>
	  <tr>
	     <td>6</td>
	     <td><?php echo $ranking[5]['name']; ?></td>
	     <td><?php echo $ranking[5]['allsales']; ?></td>
	  </tr>  
	  <tr>
	     <td>7</td>
	     <td><?php echo $ranking[6]['name']; ?></td>
	     <td><?php echo $ranking[6]['allsales']; ?></td>
	  </tr>
	  <tr>
	     <td>8</td>
	     <td><?php echo $ranking[7]['name']; ?></td>
	     <td><?php echo $ranking[7]['allsales']; ?></td>
	  </tr>
	  <tr>
	     <td>9</td>
	     <td><?php echo $ranking[8]['name']; ?></td>
	     <td><?php echo $ranking[8]['allsales']; ?></td>
	  </tr>
	  <tr>
	     <td>10</td>
	     <td><?php echo $ranking[9]['name']; ?></td>
	     <td><?php echo $ranking[9]['allsales']; ?></td>
	  </tr>
	</table>
</div>

<div class="copy">&copy;亿家净水提供技术支持</div>
</body>
</html>
