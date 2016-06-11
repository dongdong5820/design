<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>装饰器模式</title>
</head>

<body>
装饰器模式：如果已有对象的部分内容或功能性发生变化，但是不需要修改原来对象的结构，那么使用装饰器设计模式最合适；
目的：为了在不修改对象结构的前提下对现有对象的内容或功能性稍加修改。
<br/>

<?php
class CD {
	public $tracklist;

	public function __construct(){
		$this->tracklist = array();
	}
	public function addTrack($track){
		$this->tracklist[] = $track;
	}
	public function getTrackList(){
		$output = '';
		foreach($this->tracklist as $num=>$track){
			$output .= ($num+1) . ") {$track} ";
		}
		return $output;
	}
}
$tracksFromExternalSource = array('What It Means','Brr','Goodbye');
$myCD = new CD();
foreach($tracksFromExternalSource as $track){
	$myCD->addTrack($track);
}
print "The CD contains:".$myCD->getTrackList();
echo "<br/>";

class CDTrackListDecoratorCaps{
	private $_cd;
	public function __construct(CD $cd){
		$this->_cd = $cd;
	}
	public function makeCaps(){
		foreach ($this->_cd->tracklist as &$track) {
			$track = strtoupper($track);
		}
	}
}

$myCDCaps = new CDTrackListDecoratorCaps($myCD);
$myCDCaps->makeCaps();

print "The CD contains the following tracks: " . $myCD->getTrackList();

?>
</body>
</html>