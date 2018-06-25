<?php
class authorModules extends Modules
{

	//取得用户资料
	Public Function userinfo($str)
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$sql = "SELECT userid,username FROM ".DB_MEMBERS.".users WHERE userid = $userid ";
		$row = $this->db->getRow($sql);
		if($row)
		{
			$query = "SELECT mobile FROM ".DB_MEMBERS.".bind_mobile WHERE userid = ".$row["userid"];
			$info = $this->db->getRow($query);
			$row["mobile"] = $info["mobile"];
		}
		return $row;
	}

	//记录用户登录状态
	Public Function sync($str="")
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$sessid = plugin::random(5);
		$this->cookie->set('userid',$userid);
		$this->cookie->set('username',$username);
		$this->cookie->set('source',$source);
		$this->cookie->set('sessid',$sessid);
		$paramArr = array(
			'userid'	=> (int)$userid,
			'username'	=> $username,
			'source'	=> $source
		);
		$sign = plugin::buildsafe($paramArr,$sessid);	//Sign Key
		$this->cookie->set('sign',$sign);
		return true;
	}
	
	//加密检查
	Public Function checksafe($str)
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$timemap = time()-800;
		if($timemap < $dateline){ //有效时长5分钟
			$paramArr = array(
				'appid'		=>	$appid,
				'userid'	=>	$userid,
				'username'	=>	$username,
				'source'	=>	$source,
				'dateline'	=>	$dateline
			);
			$sign = $this->buildsafe($paramArr,$appkey);
			if($sign==$token){
				return true;	//检测通过
			}
		}
		return false;
	}
	
	//判断登录
	Public Function checked()
	{
		$userid		= $this->cookie->get("userid");
		$username	= $this->cookie->get("username");
		$source		= $this->cookie->get("source");
		$sessid		= $this->cookie->get("sessid");
		$sign		= $this->cookie->get("sign");
		$paramArr	= array(
			'userid'	=> $userid,
			'username'	=> $username,
			'source'	=> $source
		);
		$signed		= plugin::buildsafe($paramArr,$sessid);	//Sign Key
		//echo $signed."<br>".$sign;exit;
		if($signed!=$sign){
			return false;
		}
		return true;
	}
	
    //生成用户的回调地址
	public function record($str="")	//appid + appkey + userid + username
	{
		$str = plugin::extstr($str);//处理字符串
		extract($str);
		$dateline = time();
		$paramArr = array(
			'appid'		=>	$appid,
			'userid'	=>	$userid,
			'username'	=>	$username,
			'source'	=>	$source,
			'dateline'	=>	$dateline
		);
		if($sync){ $sync = "do=sync&"; }	//如果是同步状态至1J.CN
		$token = $this->buildsafe($paramArr,$appkey);
		$url = $sync."userid=".$userid."&username=".urlencode($username)."&source=".urlencode($source)."&dateline=".$dateline."&token=".$token;
		return $url;
	}

	//退出登陆，注销COOKIE
	Public Function logout()
	{
		$this->cookie->dispose();
		return 1;
	}
	
	//安全加密
	Public Function buildsafe($paramArr,$appkey)	//paramArr = array[]
	{
		$sign = "";
		ksort($paramArr);
		foreach($paramArr AS $key=>$val){
			if($key!=""&&$val!=""){
				$sign.=$key.$val;
			}
		}
		$sign = strtoupper(md5($appkey.$sign.$appkey));
		return $sign;
	}
	
}
?>