<?php
/**
+------------------------------------------------------------------------------
* Spring Framework 图形验证码
+------------------------------------------------------------------------------
* @date    2008-02-21
* @oicq    28683
* @author  杰夫 <darqiu@gmail.com>
* @version 2.0
+------------------------------------------------------------------------------
*/
class verifyimg
{
	Public  $text = null;	//验证码上的文字
	private $font = 5;		//字体文件路径或者整数1-5（系统内部字体）
	private $x = 5;			//首字符x坐标
	private $y = 1;			//首字符y坐标
	private $width = 50;	//图片宽度
	private $height = 18;	//图片高度 
	private $bgColor = array(255, 255, 255);
	private $textColor = array(0, 0, 0);
	private $borderColor = array(110, 110, 110);
	private $noiseColor = array();
	private $noiseRate = 0.3;
	private $textSpace = 2;		//字间距
	private $image = null;
	private $vName = 'authnum998';	//验证变量名
	
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
	* 属性访问器(写)
	+----------------------------------------------------------
	* @access public function
	+----------------------------------------------------------
	*/
	public function __set($name,$value)
	{
		if(property_exists($this,$name))
		{
			$this->$name = $value;
		}
	}

	/**
	+----------------------------------------------------------
	* 创建图像
	+----------------------------------------------------------
	* @access public function
	+----------------------------------------------------------
	*/
	public function create()
	{
		$len = strlen($this->text);
		
		//载入字体
		if(!is_int($this->font))
		{
			$this->font = imageloadfont($this->font);
		}
		
		//设置文字位置
		if(is_null($this->x))
		{
			$this->x = $this->textSpace;
		}
		if(is_null($this->y))
		{
			$this->y = $this->textSpace;
		}
		
		//设置宽度
		if(is_null($this->width))
		{
			if ($len == 0)
			{
				$this->width = $this->x * 2;
			}
			else
			{
				$this->width = $this->textSpace * ($len - 1) + imagefontwidth($this->font) * $len + $this->x * 2;
			}
		}
		
		//设置高度
		if (is_null($this->height))
		{
			$this->height = imagefontheight($this->font) + $this->y * 2;
		}
		//噪声数量
		$noiseNum = floor($this->height * $this->width * $this->noiseRate);
		$this->image = imagecreatetruecolor($this->width, $this->height);
		//$this->image = imagecreate($this->width, $this->height);   //如果服务器不支持真彩色
		$colorBG = imagecolorallocate ($this->image, $this->bgColor[0], $this->bgColor[1], $this->bgColor[2]);
		$colorText = imagecolorallocate($this->image, $this->textColor[0], $this->textColor[1], $this->textColor[2]);
		$colorBorder = imagecolorallocate($this->image, $this->borderColor[0], $this->borderColor[1], $this->borderColor[2]);
		$colorNoise = count($this->noiseColor) == 3 ? imagecolorallocate($this->image, $this->noiseColor[0], $this->noiseColor[1], $this->noiseColor[2]) : null;
		
		//填充背景
		imagefilledrectangle($this->image, 0, 0, $this->width - 1,$this->height - 1, $colorBG);
		//绘制边框
		imagerectangle($this->image, 0, 0, $this->width - 1,$this->height - 1, $colorBorder);
		$isAutoNoiseColor = count($this->noiseColor) != 3;
		
		//绘制噪音
		for($i = 0; $i < $noiseNum; $i++)
		{
			if ($isAutoNoiseColor)
			{
				$colorNoise = imagecolorallocate($this->image, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
			}
			imagesetpixel($this->image, mt_rand(0, $this->width), mt_rand(0, $this->height), $colorNoise);
		}
		
		//绘制文字
		for($i = 0; $i < strlen($this->text); $i++)
		{
			$chr = $this->text[$i];
			$x = $this->x + ($this->textSpace + imagefontwidth($this->font)) * $i;
			imagestring($this->image, $this->font, $x, $this->y, $chr, $colorText);
		}
	}

	/**
	+----------------------------------------------------------
	* 生成验证码上的文字
	+----------------------------------------------------------
	* @access public function
	+----------------------------------------------------------
	* @return string
	+----------------------------------------------------------
	*/
	public function getRandNum()
	{
		srand((double)microtime()*10000000);
		while(($authNum = rand()%10000)<1000);
		$randCode = strtoupper(substr(md5($authNum),1,4));
		$sign = $this->buildsafe($randCode);
		$this->cookie($sign);
		return $randCode;
	}

	/**
	+----------------------------------------------------------
	* 验证输入的验证码
	+----------------------------------------------------------
	* @access public function
	+----------------------------------------------------------
	* @param string $authNum 
	+----------------------------------------------------------
	* @return boolen
	+----------------------------------------------------------
	*/
	public function verify($authNum='')
	{
		$authNum = strtoupper($authNum);
		if(!isset($_COOKIE[$this->vName])) return false;
		if($this->buildsafe($authNum) != $_COOKIE[$this->vName])
		{
			$this->cookie("");
			return false;
		}
		else
		{
			$this->cookie("");
			return true;
		}
	}

	/**
	+----------------------------------------------------------
	* 验证输入的验证码
	+----------------------------------------------------------
	* @access public function
	+----------------------------------------------------------
	* @param string $authNum 
	+----------------------------------------------------------
	* @return boolen
	+----------------------------------------------------------
	*/
	public function checked($authNum='')
	{
		$authNum = strtoupper($authNum);
		if(!isset($_COOKIE[$this->vName])) return false;
		if($this->buildsafe($authNum) != $_COOKIE[$this->vName])
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	/**
	+----------------------------------------------------------
	* 输出验证码图片
	+----------------------------------------------------------
	* @access public function
	+----------------------------------------------------------
	*/
	public function show()
	{
		//ob_clean();
		header("Content-type:image/png");
		imagepng($this->image);
		imagedestroy($this->image);
	}

	/**
	+----------------------------------------------------------
	* COOKIE记录
	+----------------------------------------------------------
	* @access public function
	+----------------------------------------------------------
	*/
	public function cookie($value)
	{
		$expire = time()+3600;
		return setcookie($this->vName,$value,$expire,'/','');
	}

	/**
	+----------------------------------------------------------
	* 数据安全组合
	+----------------------------------------------------------
	* @access public function
	+----------------------------------------------------------
	*/
	public function buildsafe($nums)
	{
		$sign = "";
		$keys = date("mYd")."95000c326f12651569a4bc4ede2769ce";
		$sign = strtoupper(md5($keys.$nums.$keys.$nums.$keys.$nums.$keys));
		return $sign;
	}

}
?>