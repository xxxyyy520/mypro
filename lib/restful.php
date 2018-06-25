<?php
/**
+------------------------------------------------------------------------------
* Spring Restful 常用 
+------------------------------------------------------------------------------
* @Date		2013-06-20
* @QQ		28683
* @Author	Jeffy (darqiu@gmail.com)
* @version	2.0
+------------------------------------------------------------------------------
*/
class restful
{	
	
	Function httpcode($code='404',$msg='')
	{
		$protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
		header($protocol." $code ".$msg);
	}
	
	Function message($code="404",$msg="No Page")
	{
		return json_encode(array('code' => $code,'message' => $msg));
	}
	
	// 获取客户端提交的HTTP头内容
	Function digest_response(){
	
		if(isset($_SERVER['PHP_AUTH_DIGEST']))
		{
			$auth_data = $_SERVER['PHP_AUTH_DIGEST'];
		}
		elseif(isset($_SERVER['HTTP_AUTHORIZATION']))
		{
			$auth_data = $_SERVER['HTTP_AUTHORIZATION'];
		}
		return $auth_data;
	}
	
	// 分析客户端提交的认证头
	Function digest_parse($auth_header)
	{
		$needed_parts = array('nonce'=>1, 'nc'=>1, 'cnonce'=>1, 'qop'=>1, 'username'=>1, 'uri'=>1, 'response'=>1);
		$data = array();
		$keys = implode('|', array_keys($needed_parts));
		preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $auth_header, $matches, PREG_SET_ORDER);
		foreach ($matches as $m) {
			$data[$m[1]] = $m[3] ? $m[3] : $m[4];
			unset($needed_parts[$m[1]]);
		}
		return $needed_parts ? false : $data;
	}
	
}	
?>