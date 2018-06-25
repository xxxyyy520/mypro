<?php
class curl
{

	//获取WEB源代码
	public function contents($url,$vars="")
	{
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);	//SSL
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);	//SSL
		curl_setopt($ch,CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
		curl_setopt($ch,CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
		curl_setopt($ch,CURLOPT_AUTOREFERER, 1); // 自动设置Referer
		curl_setopt($ch,CURLOPT_TIMEOUT,1000);
		curl_setopt($ch,CURLOPT_HEADER, 0); // 显示返回的Header区域内容
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
		if($this->ip){
			$ip = $this->ip;
			curl_setopt($ch,CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:'.$ip, 'CLIENT-IP:'.$ip));  //构造IP
		}
		if($vars){
			curl_setopt($ch,CURLOPT_HTTPHEADER,array('Expect:'));
			curl_setopt($ch,CURLOPT_IPRESOLVE,CURL_IPRESOLVE_V4);
			curl_setopt($ch,CURLOPT_POST,1);
			curl_setopt($ch,CURLOPT_POSTFIELDS,$vars);
		}
		$file_contents = curl_exec($ch);
		curl_close($ch);
		return $file_contents;
	}

	//下载文件(文件地址，保存位置，来源页面)
	public function downfile($downfile,$savefile,$referer)
	{
		$files		= $downfile;	//文件地址
		$savefile	= $savefile;	//保存地址
		$referer	= $referer;		//来源地址
		if(!is_file($savefile)){
			$mh = curl_multi_init();
			if(!is_file($savefile)){
				$conn = curl_init($files);
				$fp = fopen ($savefile,"w");
				curl_setopt($conn,CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0)");
				curl_setopt($conn,CURLOPT_REFERER,$referer);
				curl_setopt($conn,CURLOPT_FILE,$fp);
				curl_setopt($conn,CURLOPT_HEADER,0);
				curl_setopt($conn,CURLOPT_CONNECTTIMEOUT,60);
				curl_multi_add_handle($mh,$conn);
			}
			do{
				$n = curl_multi_exec($mh,$active);
			}
			while ($active);
			curl_multi_remove_handle($mh,$conn);
			curl_close($conn);
			fclose($fp);
			curl_multi_close($mh);
		}
	}

}
?>