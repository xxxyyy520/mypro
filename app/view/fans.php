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
<title>粉丝-<?php echo META_TITLE; ?></title>
<meta name="keywords" content="<?php echo META_TITLE; ?>">
<meta name="description" content="<?php echo META_TITLE; ?>">
<link type="text/css" rel="stylesheet" href="<?php echo $S_ROOT;?>images/style.css">
</head>
<body>
<div class="header">
	<div class="fl"><a href="<?php echo $S_ROOT;?>"><i class="gbicon gbicon-ac-arrowl-on"></i></a></div>
	<div class="title">粉丝 <small>	(<?php echo $num; ?>位) </small></div>
</div>
<div class="fans">
	<div class="snav">
		<span <?php if($level == '7') echo 'class="current"'; ?> ><a href="<?php echo $S_ROOT;?>user/fans?level=7">综合</a></span>
		<span <?php if($level == '0') echo 'class="current"'; ?>><a href="<?php echo $S_ROOT;?>user/fans?level=0">普通</a></span>
		<span <?php if($level == '1') echo 'class="current"'; ?>><a href="<?php echo $S_ROOT;?>user/fans?level=1">铁杆</a></span>
		<span <?php if($level == '2') echo 'class="current"'; ?>><a href="<?php echo $S_ROOT;?>user/fans?level=2">铜牌</a></span>
		<span <?php if($level == '3') echo 'class="current"'; ?>><a href="<?php echo $S_ROOT;?>user/fans?level=3">银牌</a></span>
		<span <?php if($level == '4') echo 'class="current"'; ?>><a href="<?php echo $S_ROOT;?>user/fans?level=4">金牌</a></span>
		<span <?php if($level == '5') echo 'class="current"'; ?>><a href="<?php echo $S_ROOT;?>user/fans?level=5">铂金</a></span>
		<span <?php if($level == '6') echo 'class="current"'; ?>><a href="<?php echo $S_ROOT;?>user/fans?level=6">钻石</a></span>
	</div>

	<?php if($list){ ?>
	<ul class="orders-list">
		<?php foreach ($list as $value): 
			$name = $value['name1']?$value['name1']:($value['name2']?$value['name2']:$value['name3']);
			switch ((int)$value['agencylevel']) {
			case 1:
		        $level = '铁';
		        break;
		      case 2:
		        $level = '铜';
		        break;
		      case 3:
		        $level = '银';
		        break;
		      case 4:
		        $level = '金';
		        break;
		      case 5:
		        $level = '铂';
		        break;
		      case 6:
		        $level = '钻';
		        break;
		      default:
		        $level = '普';
		        break;
		    }
		?>
		<li>
	      <div class="mc">
	          <div class="title"><?php echo $name; ?> <sup class="level <?php echo 'level'.$value['agencylevel']; ?>"><?php echo $level; ?></sup> <span class="fr cgray"><?php echo $value['fans']; ?>位粉</span></div>
	          <div class="desc"><?php echo date('Y-m-d H:i',$value['dateline']); ?></div>
	      </div>
	    </li>
	<?php endforeach; ?>

	</ul>
	<?php  if($pages): ?>
	<div class="ucenter">
	  <div class="pagination"><?php echo $pages;?></div>
	</div>

	<?php endif; 
	}else{ ?>
	<div class="ucenter msgbox cgray">无粉丝记录！</div>
	<?php } ?>
</div>
<div class="copy">&copy;亿家净水提供技术支持</div>
</body>
</html>
