<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>数据访问对象模式</title>
</head>

<body>
数据访问对象模式：描述了如何创建提供透明访问任何数据源的对象；
目的：减少重复好热数据源抽象化。

<?php
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','root');
define('DB_DADABASE','autobeauty');

// 数据库抽象类
abstract class baseDAO{
	private $_connection;
	public function __construct(){
			$this->_connectToDB(DB_USER,DB_PASS,DB_HOST,DB_DADABASE);
	}
	private function _connectToDB($user,$pass,$host,$database){
		$this->_connection = mysql_connect($host,$user,$pass);
		mysql_select_db($database, $this->_connection);
		mysql_query("set names utf8", $this->_connection);
	}
	public function fetch($value,$key=null){
		if(is_null($key)){
			$key = $this->_primaryKey;	
		}
		$sql = "select * from {$this->_tableName} where {$key}='{$value}'";
		$results = mysql_query($sql, $this->_connection);
		$rows = array();
		while($res = mysql_fetch_array($results, MYSQL_ASSOC)){
			$rows[] = $res;
		}
		if($key == $this->_primaryKey){
			return $rows[0];
		}
		return $rows;
	}
	public function update($array){
		$sql = "update {$this->_tableName} set ";
		foreach($array as $column=>$value){
			$updates[] = "{$column}='{$value}'";
		}	
		$sql .= implode(",", $updates);
		$sql .= " where {$this->_primaryKey}='{$array[$this->_primaryKey]}'";
		mysql_query($sql, $this->_connection);
		return $this->_affected_rows();
	}
	private function _affected_rows(){
		return mysql_affected_rows($this->_connection);	
	}
}

// 具体的类--- 用户类
class hremployee extends	 baseDAO{
	protected $_tableName = 'hremployee';
	protected $_primaryKey = 'id';
	
	public function getUserByUserId($userid){
		return $this->fetch($userid, 'userid');
	}
}

// 实例化对象
$user = new hremployee();
$userInfo = $user->fetch(2);
echo '</br>';
print_r($userInfo);

$data = array("id"=>2,"userid"=>"zhangjun","username"=>"张军");
$int = $user->update($data);
echo '</br>';
var_dump($int);

$allusers = $user->getUserByUserId("guanxb");
echo '</br>';
print_r($allusers);

?>
</body>
</html>