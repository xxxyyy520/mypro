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
<title>订单中心-<?php echo META_TITLE; ?></title>
<meta name="keywords" content="<?php echo META_TITLE; ?>">
<meta name="description" content="<?php echo META_TITLE; ?>">
<link type="text/css" rel="stylesheet" href="<?php echo $S_ROOT;?>images/style.css">
</head>
<body>
<div class="header">
	<div class="fl"><a href="<?php echo $S_ROOT;?>"><i class="gbicon gbicon-ac-arrowl-on"></i></a></div>
	<div class="title">订单中心</div>
</div>

<?php if($list){ 
    $name = $list[0]['name1']?$list[0]['name1']:($list[0]['name2']?$list[0]['name2']:$list[0]['name3']);
    switch ((int)$list[0]['agencylevel']) {
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
<ul class="orders-list">
  <?php foreach ($list as $value): 
    $status = (int)$value['status'];
    if($status == 1){
      $status = '已完成';
      $statusclass = 'cgreen';
    }elseif($status == -1 || $status == 7){
      $status = '已取消';
      $statusclass = 'cgray';
    }else{
      if($value['paystatus'] == 0){
        $status = '待支付';
        $statusclass = 'cred';
      }else{
        $status = '配送中';
        $statusclass = 'corg';
      }
    }
  ?>
	<li>
      <div class="mh"><?php echo $name; ?> <span class="level <?php echo 'level'.$value['agencylevel']; ?>"><?php echo $level; ?></span><span class="fr <?php echo $statusclass; ?>"><?php echo $status; ?></span></div>
      <div class="mc">
      	  <a href="<?php echo $S_ROOT;?>product/ordersinfo?id=<?php echo base64_encode($value['id']); ?>" target="_blank">
	          <div class="title">订单编号：<?php echo $value['id']; ?></div>
	          <div class="desc"><?php echo $value['title']; ?> <span class="fr price"><small>￥</small><?php echo $value['price']; ?></span></div>
	          <div class="desc"><?php echo $value['datetime']; ?></div>
          </a>
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
<div class="ucenter msgbox cgray">您暂无订单记录！</div>
<?php } ?>

<div class="copy">&copy;亿家净水提供技术支持</div>
</body>
</html>
