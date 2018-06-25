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
<title>申请提现-<?php echo META_TITLE; ?></title>
<meta name="keywords" content="<?php echo META_TITLE; ?>">
<meta name="description" content="<?php echo META_TITLE; ?>">
<link type="text/css" rel="stylesheet" href="<?php echo $S_ROOT;?>images/style.css?<?php echo time() ?>">
</head>
<body>
<div class="header">
	<div class="fl"><a href="<?php echo $S_ROOT ?>"><i class="gbicon gbicon-ac-arrowl-on"></i></a></div>
	<div class="title">申请提现</div>
</div>
<div class="reg">
    <div class="form-hd">* 提示：请先完善认证资料并认真核对输入信息，信息错误将无法完成提现</div>
	<form action="<?php echo $S_ROOT ?>user/realname" method="post" name="subform" id="subform" enctype="multipart/form-data">
	<div class="form">
		<div class="item"><label>类型</label>
			<span class="radioround"><input type="radio" name="type" value="0" checked="checked" onclick="chargetype()"> 个人</span>
			<span class="radioround"><input type="radio" name="type" value="1" onclick="chargetype()"> 企业</span>
		</div>
		<div class="box-private">
			<div class="item"><label>真实姓名</label><input type="text" name="username" id="username" placeholder="您的真实姓名"></div>
			<div class="item"><label>身份证号</label><input type="text" name="identityid" id="identityid" placeholder="您的有效证件号码"></div>
			<div class="item"><label>所属银行</label>
				<select name="cardtype" id="cardtype">
					<?php foreach ($banktype as $value): ?>
						<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
					<?php endforeach; ?>
			    </select>
		    </div>
			<div class="item"><label>银行账号</label><input type="text" name="cardid" id="cardid" placeholder="持卡人本人银行账号"></div>
			<div class="item"><label>开户银行</label><input type="text" name="cardname" id="cardname" placeholder="例：招行武汉支行光谷分行"></div>
			<div class="item clear"><label>身份证照</label>
				<div class="img-reset">
					<div class="img-pre"><img  id="uploadPreviewa"  src="<?php echo $S_ROOT;?>images/upload.png"  alt="选择图片" /></div>
					<div class="img-upload">
						<input type="hidden" name="certfileaold" id="certfileaold" value="">
						<input type="file" name="certfilea" id="certfilea"  onchange="loadImageFilea();">
						<a href="javascript:;" onclick="certfilea.click()"  class="cancel">上传正面…</a>
					</div>
				</div>
                <div class="img-reset">
                    <div class="img-pre"><img  id="uploadPreviewb" src="<?php echo $S_ROOT;?>images/upload.png"  alt="选择图片" /></div>
                    <div class="img-upload">
						<input type="hidden" name="certfilebold" id="certfilebold" value="">
						<input type="file" name="certfileb" id="certfileb"  onchange="loadImageFileb();">
						<a href="javascript:;" onclick="certfileb.click()"  class="cancel">上传反面…</a>
				    </div>
                </div>
				<div class="img-redesc clear">* 请上传有效身份证照正反面</div>
			</div>
		</div>

		<div class="box-company" style="display:none">
			<div class="item"><label>企业名称</label><input type="text" name="username1" id="username1" placeholder="所属企业名称"></div>
			<div class="item"><label>营业执照</label><input type="text" name="identityid1" id="identityid1" placeholder="营业执照号码"></div>
			<div class="item"><label>所属银行</label>
				<select name="cardtype1" id="cardtype1">
					<?php foreach ($banktype as $value): ?>
						<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
					<?php endforeach; ?>
			    </select>
		    </div>
			<div class="item"><label>企业账号</label><input type="text" name="cardid1" id="cardid1" placeholder="所属企业银行账号"></div>
			<div class="item"><label>开户银行</label><input type="text" name="cardname1" id="cardname1" placeholder="例：招行武汉支行光谷分行"></div>
			<div class="item clear"><label>营业执照</label>
                <div class="img-reset">
                    <div class="img-pre"><img  id="uploadPreview" src="<?php echo $S_ROOT;?>images/upload.png"  alt="选择图片" /></div>
                    <div class="img-upload">
						<input type="hidden" name="certfileaold" id="certfilebold" value="">
						<input type="file" name="certfile" id="certfile"  onchange="loadImageFile();">
						<a href="javascript:;" onclick="certfile.click()"  class="cancel">上传执照…</a>
				    </div>
                </div>
				<div class="img-redesc clear">* 请上传有效营业执照</div>
			</div>
		</div>
		<div class="butn" id="subbutn" onclick="checkcharge()">保存</div>
	</div>
    </form>
</div>

<div class="copy">&copy;亿家净水提供技术支持</div>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/plugin.js"></script>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/checkform.js?<?php echo time() ?>"></script>
<script type="text/javascript">
oFReadera = new FileReader(), rFiltera = /^(?:image\/bmp|image\/cis\-cod|image\/gif|image\/ief|image\/jpeg|image\/jpeg|image\/jpeg|image\/pipeg|image\/png|image\/svg\+xml|image\/tiff|image\/x\-cmu\-raster|image\/x\-cmx|image\/x\-icon|image\/x\-portable\-anymap|image\/x\-portable\-bitmap|image\/x\-portable\-graymap|image\/x\-portable\-pixmap|image\/x\-rgb|image\/x\-xbitmap|image\/x\-xpixmap|image\/x\-xwindowdump)$/i;
oFReadera.onload = function (oFREvent) {
       document.getElementById("uploadPreviewa").style.display = "block";
        document.getElementById("uploadPreviewa").src     = oFREvent.target.result;
};
function loadImageFilea() {
  if (document.getElementById("certfilea").files.length == 0) { return; }
  var oFile = document.getElementById("certfilea").files[0];
  if (!rFiltera.test(oFile.type)) { msgbox("图片格式选择不正确!"); return; }
  oFReadera.readAsDataURL(oFile);
}

oFReaderb = new FileReader(), rFilterb = /^(?:image\/bmp|image\/cis\-cod|image\/gif|image\/ief|image\/jpeg|image\/jpeg|image\/jpeg|image\/pipeg|image\/png|image\/svg\+xml|image\/tiff|image\/x\-cmu\-raster|image\/x\-cmx|image\/x\-icon|image\/x\-portable\-anymap|image\/x\-portable\-bitmap|image\/x\-portable\-graymap|image\/x\-portable\-pixmap|image\/x\-rgb|image\/x\-xbitmap|image\/x\-xpixmap|image\/x\-xwindowdump)$/i;
oFReaderb.onload = function (oFREvent) {
        document.getElementById("uploadPreviewb").style.display = "block";
        document.getElementById("uploadPreviewb").src     = oFREvent.target.result;
};
function loadImageFileb() {
  if (document.getElementById("certfileb").files.length == 0) { return; }
  var oFile = document.getElementById("certfileb").files[0];
  if (!rFilterb.test(oFile.type)) { msgbox("图片格式选择不正确!"); return; }
  oFReaderb.readAsDataURL(oFile);
}

oFReader = new FileReader(), rFilter = /^(?:image\/bmp|image\/cis\-cod|image\/gif|image\/ief|image\/jpeg|image\/jpeg|image\/jpeg|image\/pipeg|image\/png|image\/svg\+xml|image\/tiff|image\/x\-cmu\-raster|image\/x\-cmx|image\/x\-icon|image\/x\-portable\-anymap|image\/x\-portable\-bitmap|image\/x\-portable\-graymap|image\/x\-portable\-pixmap|image\/x\-rgb|image\/x\-xbitmap|image\/x\-xpixmap|image\/x\-xwindowdump)$/i;
oFReader.onload = function (oFREvent) {
        document.getElementById("uploadPreview").style.display = "block";
        document.getElementById("uploadPreview").src     = oFREvent.target.result;
};
function loadImageFile() {
  if (document.getElementById("certfile").files.length == 0) { return; }
  var oFile = document.getElementById("certfile").files[0];
  if (!rFilter.test(oFile.type)) { msgbox("图片格式选择不正确!"); return; }
  oFReader.readAsDataURL(oFile);
}
</script>
</body>
</html>
