<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>适配器模式</title>
</head>

<body>
适配器设计模式只是将某个对象的接口适配为另一个对象所期望的接口
<?php
class errorObject{
	private $_error;
	public function __construct($error){
		$this->_error = $error;
	}
	public function getError(){
		return $this->_error;
	}
}
// 所期望对象的类
class logToCSV{
	const CSV_LOCATION = 'log.csv';
	private $_errorObject;
	public function __construct($errorObject){
		$this->_errorObject = $errorObject;
	}
	public function write(){
		$line = $this->_errorObject->getErrorNumber();
		$line .= ',';
		$line .= $this->_errorObject->getErrorText();
		$line .= '\n';
		
		file_put_contents(self::CSV_LOCATION,$line,FILE_APPEND);
	}
}
// 适配类
class logToCSVAdapter extends errorObject{
	private $_errorNumber,$_errorText;
	public function __construct($error){
		parent::__construct($error);
		$parts = explode(":", $this->getError());
		$this->_errorNumber = $parts[0];
		$this->__errorText = $parts[1];
	}
	public function getErrorNumber(){
		return $this->_errorNumber;
	}
	public function getErrorText(){
		return $this->__errorText;
	}
}

// 实例化对象，运行
$error = new logToCSVAdapter("404: Not Found");
$log = new logToCSV($error);
$log->write();


?>
</body>
</html>