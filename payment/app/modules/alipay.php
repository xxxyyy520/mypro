<?php
class alipayModules extends Modules
{
	//+--------------------------------------------------------------------------------------------
	  //Desc:alipay_return
	public function alipay_return()
	{
		require_once(LIB."alipay/alipay.config.php");
		require_once(LIB."alipay/alipay_notify.class.php");
		//计算得出通知验证结果
		$alipayNotify = new AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyReturn();
		if($verify_result){
			//商户订单号
			$out_trade_no	= $_GET['out_trade_no'];
			//获取总价格
			$total_fee		= $_GET['total_fee'];
			//获取交易类型
			$payment_type	= $_GET['payment_type'];
			//支付宝付款ID
			$buyer_email	= $_GET['buyer_email'];
			//支付宝交易号
			$trade_no		= $_GET['trade_no'];
			//交易状态
			$trade_status	= $_GET['trade_status'];
			if($_GET['trade_status'] == 'TRADE_SUCCESS'||$_GET['trade_status'] == 'WAIT_SELLER_SEND_GOODS'){
				if($payment_type=="1"){


					//更新支付记录的确认状态
					$query = " SELECT id,status FROM ".DB_ORDERS.".charge_callsale WHERE paynum = '$out_trade_no' ";
					$row = $this->db->getRow($query);
					$id  = (int)$row["id"];
					if($row["status"]!="1"){
						$arr = array(
								'price'		=> $total_fee,
								'detail'	=> "通过 whpay@shui.cn 回款：".$total_fee."元，客户支付宝ID ".$buyer_email."，交易号：".$trade_no."",
								'status'	=> 1
						);
						$where = array('paynum'=>$out_trade_no);
						$this->db->update(DB_ORDERS.".charge_callsale",$arr,$where);

						$query = " SELECT chargeid
 						FROM ".DB_ORDERS.".charge_callsaleinfo
 						WHERE id = $id ";
						$rows = $this->db->getRows($query);
						if($rows){
							foreach($rows AS $rs){
								$where	= array("id"=>(int)$rs["chargeid"]);
								$arr	= array("checked"=>1,"checkuserid"=>0,"checkdate"=>time());
								$this->db->update(DB_ORDERS.".orders_charge",$arr,$where);
							}
						}
					}

					msgbox("","回款成功！");
				}else{
					msgbox("","Type Fail！");
				}
			}

		}else{
			//验证失败
			//如要调试，请看alipay_notify.php页面的verifyReturn函数
			msgbox("","验证失败");
		}


	}

	//+--------------------------------------------------------------------------------------------
	  //Desc:alipay_notify
	public function alipay_notify()
	{
		require_once(LIB."alipay/alipay.config.php");
		require_once(LIB."alipay/alipay_notify.class.php");

		//计算得出通知验证结果
		$alipayNotify = new AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyNotify();

		if($verify_result){ //验证成功
			$out_trade_no	= $_POST['out_trade_no'];   //获取订单号
			$total_fee		= $_POST['total_fee'];      //获取总价格
			$payment_type	= $_POST['payment_type'];   //获取交易类型
			$buyer_email	= $_POST['buyer_email'];    //支付宝付款ID
			$trade_no		= $_POST['trade_no'];	    //支付宝交易号
			//交易状态
			$trade_status	= $_POST['trade_status'];
			//$this->setlog("out_trade_no:".$out_trade_no."\n total_fee:".$total_fee."\n payment_type:".$payment_type."\n buyer_email:".$buyer_email."\n trade_no:".$trade_no."\n");
			//交易类型，1=订单在线支付
			if($trade_status=="TRADE_SUCCESS"||$trade_status=="WAIT_SELLER_SEND_GOODS"||$trade_status=="TRADE_FINISHED"){
				if($payment_type=="1"){

					$query = " SELECT id,status FROM ".DB_ORDERS.".charge_callsale WHERE paynum = '$out_trade_no' ";
					$row = $this->db->getRow($query);
					$id  = (int)$row["id"];
					if($row["status"]!="1"){

						$arr = array(
								'price'		=> $total_fee,
								'detail'	=> "通过 whpay@shui.cn 回款：".$total_fee."元，客户支付宝ID ".$buyer_email."，交易号：".$trade_no."",
								'status'	=> 1
						);
						$where = array('paynum'=>$out_trade_no);
						$this->db->update(DB_ORDERS.".charge_callsale",$arr,$where);

						$query = " SELECT chargeid FROM ".DB_ORDERS.".charge_callsaleinfo WHERE id = $id ";
						$rows = $this->db->getRows($query);
						if($rows){
							foreach($rows AS $rs){
								$where	= array("id"=>(int)$rs["chargeid"]);
								$arr	= array("checked"=>1,"checkuserid"=>0,"checkdate"=>time());
								$this->db->update(DB_ORDERS.".orders_charge",$arr,$where);
							}
						}
					}
				}
				echo "success";
			}else{
				echo "fail";
			}
		}else{
			echo "fail";
		}
	}

	public function setlog($data)
	{
		//$data = "刘克发||成都市大石东路||88888888\r\n";
		$fp = fopen("alipay.txt","a");
		flock($fp, LOCK_EX) ;
		fwrite($fp,$data);
		flock($fp, LOCK_UN);
		fclose($fp);
		return 1;
	}

}
?>
