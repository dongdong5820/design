<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>委托模式</title>
</head>

<body>
委托模式：通过分配或委托至其他对象，委托设计模式能够去除核心对象中的判决和复杂的功能性；
目的：为了去除核心对象的复杂性并且能够动态添加新的功能，就应当使用委托设计模式。
<br/>

<?php
class Playlist{
	private $_songs;
	public function __construct(){
		$this->_songs = array();
	}
	public function addSong($location, $title){
		$song = array('location'=>$location, 'title'=>$title);
		$this->_songs[] = $song;
	}
	public function getM3U(){
		$m3u = "#EXTM3U\n\n";

		foreach ($this->_songs as $song) {
			$m3u .= "#EXTINF:-1,{$song['title']}\n";
			$m3u .= "{$song['location']}\n";
		}
		return $m3u;
	}
	public function getPLS(){
		$pls = "[playlist]\nNumberOfEntries=".count($this->_songs)."\n\n";
		foreach ($this->_songs as $songCount => $song) {
			$counter = $songCount + 1;
			$pls .= "File{$counter}={$song['location']}\n";
			$pls .= "Title{$counter}={$song['title']}\n";
			$pls .= "Length{$counter}=-1\n\n";
		}
		return $pls;
	}
}

$playlist = new Playlist();
$playlist->addSong('/home/aaron/music/brr.mp3', 'Brr');
$playlist->addSong('/home/aaron/music/goodbye.mp3', 'Goodbye');

$externalType = "m3u";   // pls
if($externalType == 'pls'){
	$playlistContent = $playlist->getPLS();
}else{
	$playlistContent = $playlist->getM3U();
}
print "歌曲的内容是：".$playlistContent;
echo "<br/>";

// 采用委托设计模式的新类
class newPlaylist{
	private $_songs;
	private $_typeObject;

	public function __construct($type){
		$this->_songs = array();
		$object = "{$type}Playlist";
		$this->_typeObject = new $object;
	}
	public function addSong($location, $title){
		$song = array('location'=>$location, 'title'=>$title);
		$this->_songs[] = $song;
	}
	public function getPlaylist(){
		$playlist = $this->_typeObject->getPlaylist($this->_songs);
		return $playlist;
	}
}

// m3u的委托对象
class m3uPlaylist{
	public function getPlaylist($songs){
		$m3u = "#EXTM3U\n\n";

		foreach ($songs as $song) {
			$m3u .= "#EXTINF:-1,{$song['title']}\n";
			$m3u .= "{$song['location']}\n";
		}
		return $m3u;
	}
}

// pls的委托对象
class plsPlaylist{
	public function getPlaylist($songs){
		$pls = "[playlist]\nNumberOfEntries=".count($this->_songs)."\n\n";
		foreach ($songs as $songCount => $song) {
			$counter = $songCount + 1;
			$pls .= "File{$counter}={$song['location']}\n";
			$pls .= "Title{$counter}={$song['title']}\n";
			$pls .= "Length{$counter}=-1\n\n";
		}
		return $pls;
	}
}

$externalType = "pls"; // m3u
$playlist = new newPlaylist($externalType);
$playlist->addSong('/home/aaron/music/brr.mp3', 'Brr');
$playlist->addSong('/home/aaron/music/goodbye.mp3', 'Goodbye');
$playlistContent = $playlist->getPlaylist();
print "采用委托设计模式后歌曲内容是：".$playlistContent;

?>
</body>
</html>