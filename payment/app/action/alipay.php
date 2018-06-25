<?php
class alipayAction extends Action
{
	
	public function app()
	{
		echo "no";
	}
	//+--------------------------------------------------------------------------------------------
	  //Desc:alipay_return
	public function alipay_return()
	{
		$alipay = getModel("alipay");
		$alipay->alipay_return();
	}

	//+--------------------------------------------------------------------------------------------
	  //Desc:alipay_return
	public function alipay_notify()
	{
		$alipay = getModel("alipay");
		$alipay->alipay_notify();
	}

}
?>