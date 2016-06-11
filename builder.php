<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>适配器模式</title>
</head>

<body>
建造者设计模式定义了处理其他对象的复杂构建的对象设计；
目的：消除其他对象的复杂创建过程。可以在某个对象的构造和配置方法改变时尽可能地减少重复更改代码。

<?php
// 源对象类
class product{
	protected $_type = '';
	protected $_size = '';
	protected $_color = '';
	
	public function setType($type){
		$this->_type = $type;
	}
	public function setSize($size){
		$this->_size = $size;
	}
	public function setColor($color){
		$this->_color = $color;
	}
	public function getType(){
		return $this->_type;
	}
	public function getSize(){
		return $this->_size;
	}
	public function getColor(){
		return $this->_color;
	}
}

// 建造者类
class productBuilder{
	protected $_product = NULL;
	protected $_configs = array();
	
	public function __construct($configs){
		$this->_product = new product();
		$this->_configs = $configs;
	}
	public function build(){
		$this->_product->setType($this->_configs["type"]);
		$this->_product->setSize($this->_configs["size"]);
		$this->_product->setColor($this->_configs["color"]);
	}
	public function getProduct(){
		return $this->_product;
	}
}

// 实例化对象（这里采用建造者类的build方法，减少了对象的创建过程）
$config = array("type"=>"shirt","size"=>"XL","color"=>"red");
$builder = new productBuilder($config);
$builder->build();
$product = $builder->getProduct();
echo "</br>"."type:".$product->getType();
echo "</br>"."size:".$product->getSize();
echo "</br>"."color:".$product->getColor();
?>
</body>
</html>