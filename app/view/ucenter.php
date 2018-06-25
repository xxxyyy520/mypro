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
<title>账户中心-<?php echo META_TITLE; ?></title>
<meta name="keywords" content="<?php echo META_TITLE; ?>">
<meta name="description" content="<?php echo META_TITLE; ?>">
<link type="text/css" rel="stylesheet" href="<?php echo $S_ROOT;?>images/style.css">
<script type="text/javascript">var S_ROOT = "<?php echo $S_ROOT;?>";</script>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/checkform.js?<?php echo time() ?>"></script>
</head>
<body>
<div class="header">
	<div class="fl"><a href="<?php echo $S_ROOT;?>"><i class="gbicon gbicon-ac-arrowl-on"></i></a></div>
	<div class="title">账户中心</div>
</div>
<div class="normal">
	<div class="form">
		<div class="item"><label>姓名</label> <div class="text"><?php echo $info['name'] ?></div></div>
		<div class="item"><label>编号</label> <div class="text"><?php echo $info['userid'] ?></div></div>
		<div class="item"><label>等级</label> <div class="text "><?php echo $agencylevel; ?></div></div>
		<div class="item"><label>推荐人</label> <div class="text "><?php echo $name; ?></div></div>
		<div class="item"><label>手机号</label> <div class="text "><?php echo $info['mobile'] ?></div></div>
		<!-- <div class="item"><label>账号安全</label> <div class="text textlink">&nbsp;</div></div> -->
	    <!-- <div class="item"><label>地址管理</label> <div class="text textlink">&nbsp;</div></div> -->
	</div>

	<?php if((int)$userinfo['realnamestatus'] == 2){ ?>
	<div class="form">
		<div class="item"><label>类型</label> <div class="text"><?php echo $userinfo['type']?'企业':'个人'; ?></div></div>
		<div class="item"><label>身份证号</label> <div class="text"><span class="cgray"><?php echo substr_replace($userinfo['identityid'],'***********',3,11) ?></span></div></div>
		<div class="item"><label>银行账号</label> <div class="text"><span class="cgray"><?php echo substr_replace($userinfo['cardid'],'************',3,12) ?></span></div></div>
		<div class="item"><label>开户银行</label> <div class="text"><span class="cgray"><?php echo $userinfo['cardname'] ?></span></div></div>
	</div>
<?php }else{ ?>
	<div class="form" onclick="identity()">
		<div class="item"><label>类型</label> <div class="text textlink">个人</div></div>
		<div class="item"><label>身份证号</label> <div class="text textlink"><span class="cgray">请填写身份证号</span></div></div>
		<div class="item"><label>银行账号</label> <div class="text textlink"><span class="cgray">请填写银行账号</span></div></div>
		<div class="item"><label>开户银行</label> <div class="text textlink"><span class="cgray">例如：招行武汉支行光谷分行</span></div></div>
		<div class="item"><label>身份证照</label> <div class="text textlink"><span class="cgray">请上传身份证正反面照片</span></div></div>
	</div>
<?php } ?>
</div>

<div class="copy">&copy;亿家净水提供技术支持</div>
</body>
</html>
