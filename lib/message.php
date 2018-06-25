<?php
/**
+---------------------------------------------------------------------------------------------------------------
* Spring Framework 系统提示消息
+---------------------------------------------------------------------------------------------------------------
* @date    2008-05-27
* @oicq    28683
* @author  杰夫 <darqiu@gmail.com>
* @version 2.0
+---------------------------------------------------------------------------------------------------------------
*/
class message
{
	public $msgFile   = null;

	public function __construct()
	{
	}

	public function __destruct()
	{
		$this->msgFile = null;
	}

	/**
	 +----------------------------------------------------------
	 * 显示消息提示框(带提示信息+跳转)
	 +----------------------------------------------------------
	 * @access public 
	 +----------------------------------------------------------
	 * @param  string $desc 消息文本
	 +----------------------------------------------------------
	 * @param  string  $url  跳转地址
	 +----------------------------------------------------------
	 */
	public function show($desc,$url=null,$n=0)
	{
		if($url==null){ $url="javascript:history.go(-1);";}
		if($n == 0) $this->showMsgBox($desc,$url);
		if($n == 1) $this->msgBox($desc,$url);
		if($n == 2) $this->noMsgBox($url);
		if($n == 3) $this->backMsgBox($desc);
		if($n == 4) $this->topMsgBox($desc,$url);
		if($n == 5) $this->topNoMsgBox($url);
		if($n == 6) $this->closeMsgBox($desc);
	}

	public function msgBox($desc,$url=null)
	{
		if($url==null){ $url="javascript:history.go(-1);";}
		print "<script language='javascript'>";
		print "alert('$desc');location.href='$url';";
		print "</script>";
		die();
	}

	public function noMsgBox($url=null)
	{
		if($url==null){ $url="javascript:history.go(-1);";}
		print "<script language='javascript'>";
		print "location.href='$url';";
		print "</script>";
		die();
	}

	public function backMsgBox($desc)
	{
		print "<script language='javascript'>";
		print "alert('$desc');history.go(-1);";
		print "</script>";
		die();
	}

	public function topMsgBox($desc,$url=null)
	{
		if($url==null){ $url="javascript:history.go(-1);";}
		print "<script language='javascript'>";
		print "alert('$desc');top.location.href='$url';";
		print "</script>";
		die();
	}


	public function topNoMsgBox($url=null)
	{
		if($url==null){ $url="javascript:history.go(-1);";}
		print "<script language='javascript'>";
		print "top.location.href='$url';";
		print "</script>";
		die();
	}

	public function closeMsgBox($desc)
	{
		print "<script language='javascript'>";
		print "alert('$desc');window.opener=null;window.close();";
		print "</script>";
		die();
	}

	public function showMsgBox($desc,$url=null)
	{
		if(!file_exists($this->msgFile)) 
		{
			print("<br><br>$desc<br><br>");
			print("请稍后,系统将在3秒后实现自动跳转...."); 
			die("<meta http-equiv='Refresh' content='3; url=$url'>");
		}
		$fp = fopen($this->msgFile,'r');
		$fileSize = filesize($this->msgFile);
		$strHtml = fread($fp,$fileSize);
		fclose($fp);
		$strHtml = str_replace("\"","\\\"",$strHtml);
		//<font style='color:#336600'>请稍后,系统将在3秒后实现自动跳转....</font><br>
		$tipInfo  = "$desc <br><a href='$url'>[确定]</a>";
		$gotoUrl  = "<meta http-equiv='Refresh' content='2; url=$url'>";
		eval("\$strHtml=\"$strHtml\";");
		die($strHtml);
	}

}
?>
