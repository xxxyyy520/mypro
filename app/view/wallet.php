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
<title>收入明细-<?php echo META_TITLE; ?></title>
<meta name="keywords" content="<?php echo META_TITLE; ?>">
<meta name="description" content="<?php echo META_TITLE; ?>">
<link type="text/css" rel="stylesheet" href="<?php echo $S_ROOT;?>images/style.css?<?php time(); ?>">
</head>
<body>
<div class="header">
	<div class="fl"><a href="<?php echo $S_ROOT;?>"><i class="gbicon gbicon-ac-arrowl-on"></i></a></div>
	<div class="title">收入明细</div>
</div>


<div class="wallet-info">
    <div class="desc">总收益</div>
    <div class="price"><?php echo $totalearning; ?></div>
    <div class="desc">今日收益 <?php echo $today; ?>元</div>
</div>
<div class="snav">
	<span <?php if($level == 'all') echo 'class="current"'; ?>><a href="<?php echo $S_ROOT ?>user/wallet?level=all">综合	</a></span>
	<span <?php if($level == 'one') echo 'class="current"'; ?>><a href="<?php echo $S_ROOT ?>user/wallet?level=one">一级</a></span>
	<span <?php if($level == 'two') echo 'class="current"'; ?>><a href="<?php echo $S_ROOT ?>user/wallet?level=two">二级</a></span>
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
          <div class="title"><?php echo $name; ?> <sup class="level <?php echo 'level'.$value['agencylevel']; ?>"><?php echo $level; ?></sup> <span class="fr price"><small>+</small><?php echo $value['price']; ?></span></div>
          <div class="desc"><?php echo date('Y-m-d H:i',$value['dateline']); ?></div>
      </div>
    </li>
  <?php endforeach; ?>
   	<!-- <li>
      <div class="mc">
          <div class="title">聪明一休 <span class="level level2">普</span> <span class="fr price"><small>+</small>250.00</span></div>
          <div class="desc">2018-05-22 13:12</div>
      </div>
    </li>
   	<li>
      <div class="mc">
          <div class="title">木子杨 <span class="level level3">黄</span> <span class="fr price"><small>+</small>540.00</span></div>
          <div class="desc">2018-05-22 13:12</div>
      </div>
    </li>
   	<li>
      <div class="mc">
          <div class="title">吉吉熊 <span class="level level4">铂</span> <span class="fr price"><small>+</small>100.00</span></div>
          <div class="desc">2018-05-22 13:12</div>
      </div>
    </li>
   <li>
      <div class="mc">
          <div class="title">花小怜 <span class="level level5">钻</span> <span class="fr price"><small>+</small>400.00</span></div>
          <div class="desc">2018-05-22 13:12</div>
      </div>
   </li> -->
</ul>

<?php  if($pages): ?>
<div class="ucenter">
  <div class="pagination"><?php echo $pages;?></div>
</div>

<?php endif; 

 }else{ ?>
<div class="ucenter msgbox cgray">暂无收入记录！</div>
<?php } ?>


<div class="copy">&copy;亿家净水提供技术支持</div>
</body>
</html>
