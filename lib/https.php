<?php
if ($_SERVER["HTTPS"]<>"on")
{
	$hostname = $_SERVER['HTTP_HOST'];
	if($hostname!="127.0.0.1"&&$hostname!="192.168.1.99"&&$hostname!="localhost"){
		$xredir = "https://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		header("Location:".$xredir);
		exit;
	}
}
?>
