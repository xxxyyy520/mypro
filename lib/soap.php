<?php
/**
+------------------------------------------------------------------------------
* Spring Framework 常用 
+------------------------------------------------------------------------------
* @Date		2008-02-20
* @QQ		28683
* @Author	Jeffy (darqiu@gmail.com)
* @version	2.0
+------------------------------------------------------------------------------
*/
class soap
{	

	public function call($urlto="",$obj="",$arg="")
	{
		if(!$urlto){ return; }
		$client	= new SoapClient($urlto);
		$info	= new stdClass();
		$info->arg0 = $arg;
		$param = array($info);
		$response = $client->__call($obj,$param);
		return $response->return;
	}


}
?>