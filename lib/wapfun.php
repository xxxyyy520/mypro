<?php
class wapfun
{

	Public static function checked()
	{

		$wap = $_GET["wap"];
		if($wap!=""){
			$wap = (int)$wap; setcookie("wapcookie",$wap,"0","/",""); return $wap;
		}

		$wapcookie = $_COOKIE["wapcookie"];
		if($wapcookie!=""){
			return $wapcookie;
		}

		if (isset($_SERVER['HTTP_VIA'])) return true;
		if (isset($_SERVER['HTTP_X_NOKIA_CONNECTION_MODE'])) return true;
		if (isset($_SERVER['HTTP_X_UP_CALLING_LINE_ID'])) return true;
		if (strpos(strtoupper($_SERVER['HTTP_ACCEPT']),"VND.WAP.WML") > 0) {
			// Check whether the browser/gateway says it accepts WML.
			$br = "WML";
		}else{
			$browser = isset($_SERVER['HTTP_USER_AGENT']) ? trim($_SERVER['HTTP_USER_AGENT']) : '';
			if(empty($browser)) return true;
			$mobile_os_list=array(
					'Google Wireless Transcoder',
					'Windows CE','WindowsCE',
					'Symbian','Android',
					'armv6l','armv5',
					'Mobile','CentOS',
					'mowser','AvantGo',
					'Opera Mobi','J2ME/MIDP',
					'Smartphone','Go.Web',
					'Palm','iPAQ'
			);
			 
			$mobile_token_list=array(
					'Profile/MIDP','Configuration/CLDC-',
					'160x160','176x220','240x240','240x320','320x240',
					'UP.Browser','UP.Link','SymbianOS',
					'PalmOS','PocketPC','SonyEricsson',
					'Nokia','BlackBerry','Vodafone',
					'BenQ','Novarra-Vision','Iris',
					'NetFront','HTC_','Xda_',
					'SAMSUNG-SGH','Wapaka',
					'DoCoMo','iPhone','iPod'
			);
			 
			$found_mobile = wapfun::checksubstr($mobile_os_list,$browser)|| wapfun::checksubstr($mobile_token_list,$browser);
			if($found_mobile){
				$br ="WML";
			}else{ $br = "WWW";
			}
		}
		if($br == "WML"){
			return true;
		} else {
			return false;
		}

	}

	Public static function checksubstr($list,$str){
		$flag = false;
		for($i=0;$i<count($list);$i++){
			if(strpos($str,$list[$i]) > 0){
				$flag = true;
				break;
			}
		}
		return $flag;
	}

}

?>