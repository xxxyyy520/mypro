<?php
/**
+------------------------------------------------------------------------------
* Spring Framework 加密解密
+------------------------------------------------------------------------------
* @date    2008-05-27
* @oicq    28683
* @author  杰夫 <darqiu@gmail.com>
* @Version 2.0
+------------------------------------------------------------------------------
*/
class secure
{
	Public $key = 'O6jkZTYgUquWiBrWbMgaO3QJvKTgQA';         //加密解密的钥匙

	/**
	+----------------------------------------------------------
	* 构造子
	+----------------------------------------------------------
	* @access public function
	+----------------------------------------------------------
	*/
	public function __construct()
	{
	}

	/**
	+----------------------------------------------------------
	* 实现对指定文本进行加密
	+----------------------------------------------------------
	* @access public function
	+----------------------------------------------------------
	*/
	public function encrypt($txt)
	{
		srand((double)microtime() * 1000000);
		$encryptKey = md5(rand(0, 32000));
		$ctr = 0;
		$tmp = '';
		for($i = 0;$i < strlen($txt); $i++)
		{
			$ctr = $ctr == strlen($encryptKey) ? 0 : $ctr;
			$tmp .= $encryptKey[$ctr].($txt[$i] ^ $encryptKey[$ctr++]);
		}
		return base64_encode($this->getKey($tmp, $this->key));
	}

	/**
	+----------------------------------------------------------
	* 实现对指定文本进行解密
	+----------------------------------------------------------
	* @access public function
	+----------------------------------------------------------
	*/
	public function decrypt($txt)
	{
		$txt = $this->getKey(base64_decode($txt),$this->key);
		$tmp = '';
		for($i = 0;$i < strlen($txt); $i++)
		{
			$md5  = $txt[$i];
			$tmp .= $txt[++$i] ^ $md5;
		}
		return $tmp;
	}
	
	Private function getKey($txt,$encryptKey)
	{
		$encryptKey = md5($encryptKey);
		$ctr = 0;
		$tmp = '';
		for($i = 0; $i < strlen($txt); $i++)
		{
			$ctr = $ctr == strlen($encryptKey) ? 0 : $ctr;
			$tmp .= $txt[$i] ^ $encryptKey[$ctr++];
		}
		return $tmp;
	}
}
?>
