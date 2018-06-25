<?php
class view
{
	public  $tplDir  = null;        //模板根目录
	private $factory = null;        //类厂对象
	private $tplVar  = null;        //模板变量数组 

	//+--------------------------------------------------------------------------------------------
	  //Desc:类的构造子(对象初始化)
	public function __construct()
	{
	}

	//+--------------------------------------------------------------------------------------------
	  //Desc:设置模板变量
	public function set($key,$val)
	{
		$this->tplVar[$key] = $val;
	}

	//+--------------------------------------------------------------------------------------------
	  //Desc:装载模板文件并显示
	public function display($file = null)
	{
		if($file)
		{
			$file = $this->tplDir.$file;
			if(!file_exists($file)){ msgbox("","模板文件: $file 不存在!"); }
			if(is_array($this->tplVar) && !empty($this->tplVar)) extract($this->tplVar);
			require_once($file);
		}
	}

	//+--------------------------------------------------------------------------------------------
	  //Desc:装载模板文件并返回解析后的html
	public function fetch($file = null)
	{
		if($file)
		{
			$file = $this->tplDir.$file;
			if(!file_exists($file)) msgbox("","模板文件: $file 不存在!");
			if(is_array($this->tplVar) && !empty($this->tplVar)) extract($this->tplVar);
			ob_start();
			require_once($file);
			$html = ob_get_contents();
			ob_end_clean();
			return $html;
		}
	}

	//+--------------------------------------------------------------------------------------------
	  //Desc:类的析构方法(负责资源的清理工作)
	public function __destruct()
	{
		$this->factory = null;   
		$this->tplVar  = null;
		$this->tplDir  = null;
	}
}
?>