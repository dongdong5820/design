<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>外观模式</title>
</head>

<body>
外观模式：通过在必需的逻辑和方法的集合前创建简单的外观接口，外观设计模式隐藏了来自调用对象的复杂性。
目的：在应用程序进程中的下一步骤包含许多复杂的逻辑步骤和方法调用时，最佳的做法是创建一个基于外观设计模式的对象。
<br/>

<?php
class CD{
	public $tracks = array();
	public $band = "";
	public $title = "";

	public function __construct($title, $band, $tracks){
		$this->title = $title;
		$this->band = $band;
		$this->tracks = $tracks;
	}
}

$trackSource = array('What It Means','Brr','Goodbye');
$title = 'Waste of a Rib';
$band = 'Never Again';
$cd = new CD($title, $band, $trackSource);

/*
	要为外部系统格式化CD对象，就需要创建其他两个类。第一个类用于准备CD对象的属性。要求的格式是大写形式。 另一个类则负责根据
	CD对象构建XML文档，这个类会返回由完整文档组成的一个字符串。
*/
class CDUpperCase{
	public static function makeString(CD $cd, $type){
		$cd->type = strtoupper($cd->type);
	}
	public static function makeArray(CD $cd, $type){
		$cd->type = array_map('strtoupper', $cd->type);
	}
}

class CDMakeXML{
	public static function create(CD $cd){
		$doc = new DomDocument();

		$root = $doc->createElement('CD');
		$root = $doc->appendChild($root);

		$title = $doc->createElement('TITLE', $cd->title);
		$title = $root->appendChild($title);

		$band = $doc->createElement('BAND', $cd->band);
		$band = $root->appendChild($band);

		$tracks = $doc->createElement('TRACKS');
		$tracks = $root->appendChild($tracks);

		foreach ($cd->tracks as $track) {
			$track = $doc->createElement('TRACK', $track);
			$track = $tracks->appendChild($track);
		}

		return $doc->saveXML();
	}
}

// 程序员必须通过如下方式实现这样的功能
CDUpperCase::makeString($cd, 'title');
CDUpperCase::makeString($cd, 'band');
CDUpperCase::makeArray($cd, 'tracks');
print CDMakeXML::create($cd);
echo "<br/>";

// 上述方法并不是最佳方式，我们应当针对具体的web服务调用创建一个Facade对象
class WebServiceFacade{
	public static function makeXMLCall(CD $cd){
		CDUpperCase::makeString($cd, 'title');
		CDUpperCase::makeString($cd, 'band');
		CDUpperCase::makeArray($cd, 'tracks');
		$xml = CDMakeXML::create($cd);
		return $xml;
	}
}
print WebServiceFacade::makeXMLCall($cd);

?>
</body>
</html>