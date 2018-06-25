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
<title>产品海报-<?php echo META_TITLE; ?></title>
<meta name="keywords" content="<?php echo META_TITLE; ?>">
<meta name="description" content="<?php echo META_TITLE; ?>">
<link type="text/css" rel="stylesheet" href="<?php echo $S_ROOT;?>images/style.css?<?php echo time(); ?>">
</head>
<body class="poster">
<div class="header">
	<div class="fl"><a href="<?php echo $S_ROOT;?>"><i class="gbicon gbicon-ac-arrowl-on"></i></a></div>
	<div class="title">产品海报</div>
</div>

<div class="poster-pics">
  <div class="swiper-container"  id="swiper-container1">
    <div class="swiper-wrapper">
    	<?php  
    	if($articlerows):
    		foreach ($articlerows as $value): 
    		?>
        		<div dataid="<?php echo $value['articleid']; ?>" class="swiper-slide"><img src="<?php echo "https://file.shui.cn".$value['pic'];?>" alt="轮播海报"></div>
    	<?php 
			endforeach; 
		endif; ?>
    </div>
    <?php if(count($articlerows)>1){?>
    <div class="swiper-pagination" id="swiper-pagination1"></div>
    <?php } ?>
  </div>
</div>

<div class="poster-fixed">
	<div class="poster-smallpics">
	    <div class="swiper-container" id="swiper-container2">
		    <div class="swiper-wrapper">
		    	<?php  
		    	if($topicrows):
			    	foreach ($topicrows as $value): ?>
						<div class="swiper-slide <?php if($value['topic'] == $topicid ) echo 'swiper-slide-on';?>"><a href="<?php echo $S_ROOT ?>product/poster?topicid=<?php echo $value['topic']; ?>"><img src="https://file.shui.cn<?php echo $value['pic'] ?>" alt=""></a></div>
			    <?php 
					endforeach;
			    endif; ?>
		    </div>
		    <div class="swiper-pagination" id="swiper-pagination2"></div>
	    </div>
	</div>
	<div class="poster-tool">
	    <!-- <span>分享链接</span> -->
	    <span onclick="createposter()">生成海报</span>
	</div>
</div>

<div class="poster-thumb" style="display:none;">
	<div class="con">
	   <div class="mh">长按下图保存海报到相册 <span class="fr" onclick="$('.poster-thumb').hide();">&#10005;</span></div>
	   <div class="mc"><img src="" alt="" id="posterpic"></div>
	</div>
</div>

<script type="text/javascript">var S_ROOT = "<?php echo $S_ROOT;?>";</script>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/jquery.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo $S_ROOT;?>js/touchswiper/swiper.min.css">
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/touchswiper/swiper.min.js"></script>
<script type="text/javascript">

var swiper = new Swiper('#swiper-container1', {
  effect : 'coverflow',
  slidesPerView: 1,
  centeredSlides: true,
  coverflowEffect: {
    rotate: 30,
    stretch: 10,
    depth: 60,
    modifier: 2,
    slideShadows : true
  },
  pagination: {
    el: '#swiper-pagination1',
  }
});
var swiper = new Swiper('#swiper-container2', {
	  slidesPerView: 3,
	  spaceBetween: 30,
	  navigation: {
	    nextEl: '.swiper-button-next',
	    prevEl: '.swiper-button-prev',
	  }
});

function createposter()
{
   var articleid = $("#swiper-container1").find(".swiper-slide-active").attr("dataid");
   // var topicid   = $("#topicid").val();
   $.ajax({  
	    type: "POST",  
		async: false,
	    url: S_ROOT+"product/creatposter",
	    data: "articleid="+articleid,             
	    success: function(rows){
	    	if(rows != 0){
	    		$("#posterpic").attr("src",rows);
   				$(".poster-thumb").show();
	    	}else{
	    		alert('生成失败！');
	    	}
	    }
	});	
}

</script>	
</body>
</html>
