<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>迭代器模式</title>
</head>

<body>
迭代器模式：帮助构建特定对象，那些对象能够提供单一标准接口循环或迭代任何类型的可计数数据。
目的：处理可计数和遍历数据的集合。
<br/>

<?php
// 源基类
class CD{
	public $band='';
	public $title='';
	public $trackList = array();

	public function __construct($band,$title){
		$this->band = $band;
		$this->title = $title;
	}

	public function addTrack($track){
		$this->trackList[] = $track;
	}
}

// 迭代器类
class CDSearchByBandIterator implements Iterator{
	private $_CDs = array();
	private $_valid = false;

	public function __construct($bandName){
		$db = mysql_connect('localhost','root','root');
		mysql_select_db('test');

		$sql = "select CD.id,CD.band,CD.title,tracks.tracknum,";
		$sql .= "";
	}
}






?>
</body>
</html>