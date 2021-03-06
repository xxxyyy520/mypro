<?php
/**
 +--------------------------------------------------------------------------------------------
 * Spring Framework 所有model的基类
 +--------------------------------------------------------------------------------------------
* @date		2011-01-17
* @QQ		28683
* @Author	Jeffy (darqiu@gmail.com)
* @version	2.0
 +--------------------------------------------------------------------------------------------
 */
abstract class Modules
{

	public $db = null;
	public $msg = null;

	//+--------------------------------------------------------------------------------------------
	  //Desc:类的构造子(对象初始化)
	public function __construct()
	{
	}

	//+--------------------------------------------------------------------------------------------
	  //Desc:类的析构方法(负责资源的清理工作)
	public function __destruct()
	{
		$this->db = null;
		$this->msg = null;
	}

}
?>