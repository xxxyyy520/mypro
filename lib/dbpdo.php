<?php
/**
+------------------------------------------------------------------------------
* Spring Framework 通用数据库访问接口
+------------------------------------------------------------------------------
* @date    2008-05-20
* @mobile  13501103100
* @oicq    28683
* @author  杰夫 <qiu@jiefu.org>
* @version 2.0
+------------------------------------------------------------------------------
*/
class DbPdo
{
	/**
	$db = new DbPdo;
	$db->dbType='mysql';
	$db->connectNum='mysql';
	$db->configFile = "dbconfig.php";	//数据库配置
	*********** dbconfig.php *********************
	$username = "root";
	$password = "123456";
	$hostname = "localhost";
	$dbname   = "test";
	$encode   = "utf8";
	$dsn      = "mysql:host=$hostname;dbname=$dbname";
	*/
	//数据库类型
	Public $dbType     = null;

	//连接数据库配置文件
	Public $configFile = null;

	//当前连接ID
	private $connectId = null;

	//多个连接参数
	Public $connectNum	= '0';

	//查询结果对象
	private $PDOStatement =	null;

	//查询时间记录
	private $keepProfile =	false;


	/**
	+----------------------------------------------------------
	* 类的构造子
	+----------------------------------------------------------
	* @access public function
	+----------------------------------------------------------
	*/

	public function __construct()
	{
		if(!class_exists('PDO'))
		{
			die('Not Support : PDO');
		}
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
		 $this->dbType       = null;
		 $this->configFile   = null;
		 $this->connectId    = null;
		 $this->PDOStatement = null;
	}

	/**
	+----------------------------------------------------------
	* 打开数据库连接
	+----------------------------------------------------------
	* @access public function
	+----------------------------------------------------------
	*/

	public function connect()
	{
		if($this->connectId == null)
		{
			if(!file_exists($this->configFile)) die("数据库配置文件：".$this->configFile."不存在!");
			require($this->configFile);
			$this->connectId = new PDO($dsn, $username, $password);
			$this->connectId->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING); //打开PDO错误提示
			/*
				PDO::ATTR_ERRMODE: Error reporting.
				1 PDO::ERRMODE_SILENT: Just set error codes.
				2 PDO::ERRMODE_WARNING: Raise E_WARNING.
				3 PDO::ERRMODE_EXCEPTION: Throw exceptions.
			*/
			if($this->dbType == 'mysql') $this->connectId->exec("set names $encode");
			$dsn = $username = $password = $encode = null;
			if($this->connectId == null)
			{
				die("PDO CONNECT ERROR");
			}
		}
	}

	/**
	+----------------------------------------------------------
	* 关闭数据库连接
	+----------------------------------------------------------
	* @access public function
	+----------------------------------------------------------
	*/

	public function close()
	{
		$this->connectId = null;
	}

	/**
	+----------------------------------------------------------
	* 释放查询结果
	+----------------------------------------------------------
	* @access public
	+----------------------------------------------------------
	*/

	public function free()
	{
		$this->PDOStatement = null;
	}


	/**
	* 获得一条查询结果
	*
	* @param mixed $query
	* @param array $args
	* @access public
	* @return void
	* <code>$obj= $db->getRow('SELECT * FROM tablename WHERE foo= ? AND  foo2 = ?',array('1','2'));</code>
	*/

	public function getRow($sql,$args= array())
	{
		if($this->connectId == null) $this->connect();
		$result = array();   //返回数据集
		$this->PDOStatement = $this->connectId->prepare($sql);
		$this->PDOStatement->execute($args);

		if(empty($this->PDOStatement))
		{
			$this->error($sql);
			return $result;
		}

		$result = $this->PDOStatement->fetch(constant('PDO::FETCH_ASSOC'));
		//$this->free();
		return $result;
	}


	/**
	* 获得所有的查询数据
	*
	* @param mixed $query
	* @param array $args
	* @access public
	* @return void
	* <code>$obj= $db->getRows( 'SELECT * FROM tablename WHERE foo= ?', array( 'fieldvalue' ));</code>
	*/

	public function getRows($sql,$args=array())
	{
		if($this->connectId == null) $this->connect();
		$result = array();   //返回数据集
		$this->PDOStatement = $this->connectId->prepare($sql);
		$this->PDOStatement->execute($args);
		if(empty($this->PDOStatement))
		{
			$this->error($sql);
			return $result;
		}
		$result = $this->PDOStatement->fetchAll(constant('PDO::FETCH_ASSOC'));
        $rowCount = $this->PDOStatement->rowCount();
		//$this->free();
		return $result;
	}

	/**
	+----------------------------------------------------------
	* 返回最后一次使用 INSERT 指令的 ID
	+----------------------------------------------------------
	* @access public function
	+----------------------------------------------------------
	* @return integer
	+----------------------------------------------------------
	*/

	public function getLastInsId()
	{
		if($this->connectId!= null)
		{
			return $this->connectId->lastInsertId();
		}
		return 0;
	}


    /**
	* 执行语句 针对 INSERT, UPDATE 以及DELETE
	* 带prepare与execute分离的query方法
	*
	* @param mixed $sql
	* @param array $args
	*
	* @access public
	* @return void
	*/

    public function query($sql,$args=array())
    {
		if($this->connectId == null) $this->connect();
		$result = array();   //返回数据集
		$this->PDOStatement = $this->connectId->prepare($sql);
		$this->PDOStatement->execute($args);
		if(empty($this->PDOStatement))
		{
			$this->error($sql);
			return false;
		}
		//$this->free();
		return true;
    }

	/**
	+----------------------------------------------------------
	* 获得多条查询数据(带分页条)
	+----------------------------------------------------------
	* @access public function
	+----------------------------------------------------------
	* @return array
	* string $query SQL语法
	* string $pageRows 每页数量
	* string $type  分页样式ID，与 pagenav.php 文件相应
	* string $maxpages 最大页面数量
	+----------------------------------------------------------
	*/

	public function getPageRows($query,$pagenums='20',$type='0',$args=array())
	{
			$page = isset($_GET['page']) ?(int)$_GET['page'] : 1;
			$keyid = trim($this->keyid);
			if($keyid==""){ $keys = "*"; }else{ $keys = $keyid; }
			$sqlCount = preg_replace("|select.*?from([\s])|is","select count(".$keys.") as total from $1",$query,1);
			$total = $this->getRow($sqlCount,$args);
			$total = $total['total'];
			//GROUP COUNT
			if(preg_match('!(GROUP[[:space:]]+BY|HAVING|SELECT[[:space:]]+DISTINCT)[[:space:]]+!is', $sqlCount))
			{
					$sqlCount = preg_replace('!(order[[:space:]]+BY)[[:space:]]+.*!is','', $query, 1);
					$sqlCount = preg_replace("|SELECT.*?FROM([\s])|is","SELECT ".$keys."  FROM$1", $sqlCount, 1);
					$rows     = $this->getRows($sqlCount,$args);
					//print_r($rows);exit;
					$total    = empty($rows) ? 0 : COUNT($rows);
			}
			//计算分页的偏移量
			$pageId = isset($page) ? $page : 1;
			$offset = ($pageId-1)*$pagenums;
			$offset = ($offset < 0) ? 0 : $offset;
			$query .= ' LIMIT '.$offset.','. $pagenums;
			require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'pagenav.php');
			$pagenav = new pagenav();
			$data['pages']   = $pagenav->show($total,$pagenums,$type,$maxpages);
			$data['record']	 = $this->getRows($query,$args);
			$data['total']   = $total;
			$data['maxpage'] = ceil($total/$pagenums);
			return $data;
	}


	public function groupPageRows($query,$cquery,$pagenums='20',$type='0')
	{
			$page = isset($_GET['page']) ?(int)$_GET['page'] : 1;
			$total = $this->getRow($cquery);
			$total = (int)$total['total'];
			$pageId = isset($page) ? $page : 1;
			$offset = ($pageId-1)*$pagenums;
			$offset = ($offset < 0) ? 0 : $offset;
			$query .= ' LIMIT '.$offset.','. $pagenums;
			require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'pagenav.php');
			$pagenav = new pagenav();
			$data['pages']   = $pagenav->show($total,$pagenums,$type);
			$data['record']	 = $this->getRows($query);
			$data['total']   = $total;
			$data['maxpage'] = ceil($total/$pagenums);
			return $data;
	}


	/**
	+----------------------------------------------------------
	* INSERT 添加数据(辅助方法)
	+----------------------------------------------------------
	* 对参数和sql进行了分离的insert
	+----------------------------------------------------------
	* @access public function
	+----------------------------------------------------------
	* @return void
	+----------------------------------------------------------
	*/

	public function insert($table,$fieldvalues=array(),$showed=0)
	{
		ksort($fieldvalues);

		$query= "INSERT INTO {$table} ( ";
		$comma= '';

		foreach( $fieldvalues as $field => $value ) {
			$query.= $comma.$field;
			$comma= ',';
			$values[]= $value;
		}
		$query.= ") VALUES (".trim( str_repeat( "?,", count( $fieldvalues ) ), "," ) . " );";
		$this->showed = $showed;
		if($showed=="1"){ echo $query; print_r($values); }

		return $this->query($query,$values);
	}

	public function insertsql($table,$fieldvalues=array(),$showed=0)
	{
		ksort($fieldvalues);

		$query= "INSERT INTO {$table} ( ";
		$comma= '';

		foreach( $fieldvalues as $field => $value ) {
			$query.= $comma.$field;
			$values.= $comma."'".$value."'";
			$comma= ',';
		}
		$query.= ") VALUES (".$values.");";
		echo $query;exit;
	}

	/**
	* exists
	*
	* @param mixed $table
	* @param mixed $keyfieldvalues
	* @access public
	* @return void
	* <code>DB::exists( 'mytable', array( 'fieldname' => 'value' ) );</code>
	*/

	public function exists($table,$keyfieldvalues=array())
	{
		$qry= "SELECT 1 as c FROM {$table} WHERE 1=1 ";

		$values= array();
		foreach( $keyfieldvalues as $keyfield => $keyvalue ) {
			$qry.= " AND {$keyfield}= ? ";
			$values[]= $keyvalue;
		}
        $result= $this->getRow($qry,$values);
        //print_r($result);
		return ($result!==false);
	}

	/**
	* update 更新数据(辅助方法)
	*
	* @param mixed $table
	* @param mixed $fieldvalues
	* @param mixed $keyfields
	* @access public
	* @return void
	* <code>DB::update( 'mytable', array( 'fieldname' => 'newvalue' ), array( 'fieldname' => 'value' ) );</code>
	*/

	public function update($table,$fieldvalues=array(),$keyfields='')
	{
        if($keyfields==""){ return; }
		ksort($fieldvalues);
		ksort($keyfields);
		$qry= "UPDATE {$table} SET";
		$values= array();
		$comma= '';
		foreach( $fieldvalues as $fieldname => $fieldvalue ) {
			$qry.= $comma . " {$fieldname}= ?";
			$values[]= $fieldvalue;
			$comma= ',';
		}
		if(is_array($keyfields)){
			$qry.= ' WHERE 1=1 ';
			foreach( $keyfields as $keyfield => $keyvalue ) {
				$qry.= "AND {$keyfield}= ? ";
				$values[]= $keyvalue;
			}
		}else{
			$qry.= " $where ";
		}
		return $this->query($qry,$values);
	}


	/**
	* delete 删除数据(辅助方法)
	*
	* @param mixed $table
	* @param mixed $keyfields
	* @access public
	* @return void
	* <code>DB::delete( 'mytable', array( 'fieldname' => 'value' ) );</code>
	*/
	public function delete($table,$where="")
	{
		if(!empty($where))
		{
			$sql= "DELETE FROM {$table} WHERE 1=1 ";
			if(is_array($where)){
				$values = array();
				foreach ($where as $keyfield => $keyvalue ){
					$sql.= "AND {$keyfield}= ? ";
					$values[]= $keyvalue;
				}
			}else{
				$sql.= " AND $where";
			}
			return $this->query($sql,$values);
		}
	}


	/**
	* execute_procedure
	* 执行存储过程
	* @param mixed $procedure
	* @param array $args
	* @access public
	* @return void
	*/
	public function execute($procedure,$args=array())
	{

		if( $this->PDOStatement != NULL ) {
			$this->PDOStatement->closeCursor();
		}

		/*
		* Since RDBMS handle the calling of procedures
		* differently, we need a simple abstraction
		* mechanism here to build the appropriate SQL
		* commands to call the procedure...
		*/
		$driver= $this->connectId->getAttribute(PDO::ATTR_DRIVER_NAME);
		switch($driver) {
			case 'mysql':
			case 'db2':
				/*
				* These databases use ANSI-92 syntax for procedure calling:
				* CALL procname ( param1, param2, ... );
				*/
				$query= 'CALL ' . $procedure . '( ';
				if ( count( $args ) > 0 ) {
					$query.= str_repeat( '?,', count( $args ) ); // Add the placeholders
					$query= substr( $query, 0, strlen( $query ) - 1 ); // Strip the last comma
				}
				$query.= ')';
				break;
			case 'pgsql':
			case 'oracle':
				die( "not yet supported on $driver" );
				break;
		}
		if ($this->PDOStatement = $this->connectId->prepare($query)){
			if($this->keepProfile){
				require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'queryprofile.php');
				$profile= new QueryProfile($query);
				$profile->start();
			}
			if (!$this->PDOStatement->execute($args)){
				$this->error($this->PDOStatement->errorInfo());
				return false;
			}
			if ($this->keep_profile){
				$profile->stop();
				$this->profiles[]=$profile;
			}
			return true;
		}
		else {
			$this->error($this->PDOStatement->errorInfo());
			return false;
		}
	}


	/**
	+----------------------------------------------------------
	* 执行语句(针对事务操作)
	+----------------------------------------------------------
	* @access public function
	+----------------------------------------------------------
	* @param string $SQL SQL指令
	+----------------------------------------------------------
	* @return boolean
	+----------------------------------------------------------
	*/
	public function transaction($sql)
	{
		if(!is_array($sql)) return false;
		if($this->connectId == null) $this->connect();
		$this->connectId->beginTransaction();
		try
		{
			$this->connectId->beginTransaction();
			foreach($sql as $sqlCmd)
			{
				$this->connectId->exec($sqlCmd);
			}
			$this->connectId->commit();
			return true;
		}
		catch(Exception $e)
		{
			$this->connectId->rollBack();
			print "Failed:".$e->getMessage();
		}
		return false;
	}

	/**
	+----------------------------------------------------------
	* 数据库错误信息
	* 并显示当前的SQL语句
	+----------------------------------------------------------
	* @access private
	+----------------------------------------------------------
	*/
	Private function error($sql)
	{
		if($_GET["debug"]=="1"){
			$error = $this->PDOStatement->errorInfo();
			$str = $error[2];
			if($sql!='')
			{
				$str ="[SQL]：".$sql."\n [ERROR]：".$str;
			}
			echo $str;
		}else{
			echo "系统繁忙，请稍候再试！";
		}
		exit;
	}
}
?>
