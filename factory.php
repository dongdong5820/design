<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>工厂模式</title>
</head>

<body>
工厂模式：提供获取某个对象的新实例的一个接口，同时使调用代码避免确定实际实例化基类的步骤。
目的：请求需要某些逻辑和步骤才能确定基对象的类实例时，就使用工厂设计模式。
<br/>

<?php
class CD{
	public $title ='';
	public $band = '';
	public $tracks = array();
	
	public function __construct(){
	
	}
	public function setTitle($title){
		$this->title = $title;
	}
	public function setBand($band){
		$this->band = $band;
	}
	public function addTracks($track){
		$this->tracks[] = $track;
	}
}

$title = 'Waste of a Rib';
$band = 'Never Again';
$trackSource = array('What It Means','Brr','Goodbye');

$cd = new CD();
$cd->setTitle($title);
$cd->setBand($band);
foreach($trackSource as $track){
	$cd->addTracks($track);
}
print_r($cd->tracks);
echo "<br/>";

class enhancedCD{
	public $title ='';
	public $band = '';
	public $tracks = array();
	
	public function __construct(){
		$this->tracks[] = "DATA TRACK";
	}
	public function setTitle($title){
		$this->title = $title;
	}
	public function setBand($band){
		$this->band = $band;
	}
	public function addTracks($track){
		$this->tracks[] = $track;
	}
}

// 工厂模式
class CDFactory{
	public static function create($type){
		$class = strtolower($type) . "CD";
		return new $class;
	}
}

$type = "enhanced";
$cd1 = CDFactory::create($type);
$cd1->setTitle($title);
$cd1->setBand($band);
foreach($trackSource as $track){
	$cd1->addTracks($track);
}
print_r($cd1->tracks);


?>
</body>
</html>