<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta name="author" content="" />
<title><?php echo ($msgbox)?$msgbox:"正在进入页面...";?></title>
</head>

<body>

<?php if($msgbox){?>
<link href="<?php echo $S_ROOT?>images/style.css" rel="stylesheet" type="text/css" />
<div class="divc">
  <div class="msgform">
    <div class="msgbox">
	  <ul>
	    <li class="message"><?php echo $msgbox?></li>
		<li class="msgbutton"><img src="<?php echo $S_ROOT?>images/msgbox_btn.jpg" /></li>
	  </ul>
	</div>
  </div>
</div>
<?php echo $script?>


<?php }else{?>


<?php echo "正在进入页面... ".$script?>

<?php //header("location:$urlto");?>

<?php }?>

</body>
</html>
