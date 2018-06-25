<?php
/**
+------------------------------------------------------------------------------
* Spring Framework 文件上传
+------------------------------------------------------------------------------
* @date    2008-05-24
* @oicq    28683
* @author  杰夫 <darqiu@gmail.com>
* @version 2.0
+------------------------------------------------------------------------------
*/
class upload
{
	Public	$msg     = null;    //异常消息
	Public	$path    = null;    //上传文件路径
	Public	$upFile  = null;    //上传到服务器上的文件名
	Public	$maxSize = null;    //上传文件最大大小
	Public	$upType  = null;    //上传文件类型

	/**
	 +----------------------------------------------------------
	 * 类的构造子
	 +----------------------------------------------------------
	 * @access public function
	 +----------------------------------------------------------
	 */	
	public function __construct()
	{
	}

	/**
	 +----------------------------------------------------------
	 * 类的析构方法(负责资源的清理工作)
	 +----------------------------------------------------------
	 * @access public function
	 +----------------------------------------------------------
	 */	
	public function __destruct()
	{
		 $this->msg     = null;
		 $this->path    = null;
		 $this->upFile  = null;
		 $this->maxSize = null;
		 $this->upType  = null;
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
	 * 检查上传文件信息
	 +----------------------------------------------------------
	 * @access private 
	 +----------------------------------------------------------
	 * @param  string  $name 文件名 
	 +----------------------------------------------------------
	 * @param  integer $size 文件大小
	 +----------------------------------------------------------
	 * @return boolean
	 +----------------------------------------------------------
	 */
	Private function checkFile($name,$size)
	{
		if($size > $this->maxSize)
		{
			$this->msg = "上传文件 $name 超过规定大小!";
			return false;
		}
		if(!strstr(strtolower($this->upType),strtolower($this->getFileType($name))))
		{
			$this->msg = "没有上传.".$this->getFileType($name)."文件格式的权限";
			return false;
		}
		return true;
	}

	/**
	 +----------------------------------------------------------
	 * 获取文件扩展名
	 +----------------------------------------------------------
	 * @access private 
	 +----------------------------------------------------------
	 * @param string $fileName   文件名  
	 +----------------------------------------------------------
	 * @return string
	 +----------------------------------------------------------
	 */
	Private function getFileType($fileName)
	{
		$temp = explode(".",$fileName);
		return $temp[count($temp)-1];
	}

	/**
	 +----------------------------------------------------------
	 * 修改文件名
	 +----------------------------------------------------------
	 * @access private 
	 +----------------------------------------------------------
	 * @param string $fileName   文件名  
	 +----------------------------------------------------------
	 * @return string
	 +----------------------------------------------------------
	 */
	Private function changeFileName($fileName)
	{
		return time().rand(101,999).".".$this->getFileType($fileName);
	}

	/**
	 +----------------------------------------------------------
	 * 检查路径，不存在则创建
	 +----------------------------------------------------------
	 * @access private 
	 +----------------------------------------------------------
	 * @return boolean
	 +----------------------------------------------------------
	 */
	Private function checkPath()
	{
		if(!file_exists($this->path))
		{
			$dirs = explode('/', $this->path);
			$total = count($dirs);
			$temp = '';
			for($i=0; $i<$total; $i++)
			{
				$temp .= $dirs[$i].'/';
				if (!is_dir($temp))
				{
					if(!@mkdir($temp)) 
					{
						$this->msg = "不能建立目录 $temp";
						return false;
					}
					@chmod($temp, 0777); // 改变目录权限 为0777
				}
			}
		}
		return true;
	}

	/**
	 +----------------------------------------------------------
	 * 文件上传
	 +----------------------------------------------------------
	 * @access public function
	 +----------------------------------------------------------
	 * @param array   $file    上传文件信息  
	 +----------------------------------------------------------
	 * @param boolen  $change 文件是否更名  
	 +----------------------------------------------------------
	 * @return boolean
	 +----------------------------------------------------------
	 */
	public function upload($file,$change=true)
	{
		if(!$this->checkPath()) return false;
		if(!$this->checkFile($file["name"],$file["size"])) return false;
		$fileName = ($change)?$this->changeFileName($file["name"]):$file["name"];
		$fileName = strtolower($fileName);
		if(move_uploaded_file($file["tmp_name"],$this->path."/".$fileName))
		{
			$this->upFile = $fileName;
			return true;
		}
		$this->msg = "网络故障,上传失败";
		return false;
	}
}
?>
