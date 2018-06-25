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
<title><?php echo ($_GET['ac'] == 'recruit')?"合伙人招募":$rows['title'];?>-<?php echo META_TITLE; ?></title>
<meta name="keywords" content="<?php echo META_TITLE; ?>">
<meta name="description" content="<?php echo META_TITLE; ?>">
<link type="text/css" rel="stylesheet" href="<?php echo $S_ROOT;?>images/style.css">
</head>
<body>
<div class="header">
	<div class="fl"><a href="JavaScript:history.go(-1)"><i class="gbicon gbicon-ac-arrowl-on"></i></a></div>
	<div class="title">
	<?php	echo ($_GET['ac'] == 'recruit')?"合伙人招募":$rows['title'];	?>
	</div>
</div>
<div class="reg-list">
	<?php echo str_replace("/data", "https://file.shui.cn/data",$rows['content']); ?>
</div>
<div class="copy">&copy;亿家净水提供技术支持</div>
</body>
</html>
