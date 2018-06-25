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
<title>分享技巧-<?php echo META_TITLE; ?></title>
<meta name="keywords" content="<?php echo META_TITLE; ?>">
<meta name="description" content="<?php echo META_TITLE; ?>">
<link type="text/css" rel="stylesheet" href="<?php echo $S_ROOT;?>images/style.css?<?php echo time(); ?>">
</head>
<body>
<div class="header">
	<div class="fl"><a href="<?php echo $S_ROOT;?>"><i class="gbicon gbicon-ac-arrowl-on"></i></a></div>
	<div class="title">分享技巧</div>
</div>

<?php if($list){ ?>
<ul class="news-list">
  <?php foreach ($list as $value): ?>
  <li>
   <a href="<?php echo $S_ROOT;?>article/articledetail?articleid=<?php echo base64_encode($value['articleid']); ?>">
        <div class="thumb"><img src="https://file.shui.cn<?php echo $value['pic']; ?>" width="80" height="80" alt=""></div>
        <div class="info">
	        <div class="title"><?php echo $value['title']; ?></div>
	        <div class="desc">
	             <?php echo $value['detail']; ?>
	        </div>
        </div>
   </a>
  </li>
  <?php endforeach; ?>

</ul>
<?php  if($pages): ?>
<div class="ucenter">
  <div class="pagination"><?php echo $pages;?></div>
</div>

<?php endif; 
}else{ ?>
<div class="ucenter msgbox cgray">暂无文章</div>
<?php } ?>

<div class="copy">&copy;亿家净水提供技术支持</div>
</body>
</html>
